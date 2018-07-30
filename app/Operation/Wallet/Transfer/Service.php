<?php

namespace App\Operation\Wallet\Transfer;

use App\Dto\ErroneousResponse;
use App\Exceptions\EntityNotFoundException;
use App\Models\Wallet;
use App\Operation\Common\CurrencyConverter\CurrencyConverterInterface;
use App\Operation\Wallet\History\Add\Dto\History;
use App\Operation\Wallet\History\Add\ProcessorInterface;
use App\Operation\Wallet\Transfer\Dto\Request;
use App\Repositories\WalletRepositoryInterface;
use App\Service\ServiceInterface;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

final class Service implements ServiceInterface
{
    use LoggerAwareTrait;

    const MAX_WALLET_CAPACITY = 2147483647;

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @var ProcessorInterface
     */
    private $addHistoryProcessor;

    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    /**
     * @param WalletRepositoryInterface $walletRepository
     * @param ProcessorInterface $addHistoryProcessor
     * @param CurrencyConverterInterface $currencyConverter
     * @param LoggerInterface $logger
     */
    public function __construct(
        WalletRepositoryInterface $walletRepository,
        ProcessorInterface $addHistoryProcessor,
        CurrencyConverterInterface $currencyConverter,
        LoggerInterface $logger
    ) {
        $this->setLogger($logger);

        $this->walletRepository = $walletRepository;
        $this->addHistoryProcessor = $addHistoryProcessor;
        $this->currencyConverter = $currencyConverter;
    }
    /**
     * {@inheritdoc}
     * @param Request $request
     */
    public function behave($request)
    {
        try {
            $this->logger->info('Finding wallet from');
            $walletFrom = $this->walletRepository->findOne($request->getWalletFromId());

            $this->logger->info('Finding wallet to');
            $walletTo = $this->walletRepository->findOne($request->getWalletToId());
        } catch (EntityNotFoundException $e) {
            $errorMessage = sprintf("Wallet with id: '%s' not found", $request->getWalletToId());

            $this->logger->error($errorMessage, ['e' => $e]);
            return new ErroneousResponse($errorMessage);
        }

        DB::beginTransaction();
        $amountForWalletFrom = $this->convertAmount($request, $walletFrom);
        $this->logger->info(sprintf('Amount from %s', $amountForWalletFrom));
        $amountForWalletTo = $this->convertAmount($request, $walletTo);
        $this->logger->info(sprintf('Amount to %s', $amountForWalletTo));

        $this->logger->info('Checking amount enough');
        if ($walletFrom->amount < $amountForWalletFrom) {
            return new ErroneousResponse('Not enough money');
        }

        $this->logger->info('Checking amount not to much');
        if ($walletTo->amount + $amountForWalletTo >= self::MAX_WALLET_CAPACITY) {
            return new ErroneousResponse('Amount is to big');
        }

        $this->addHistoryProcessor->process(
            new History(
                $walletFrom,
                -1 * $amountForWalletFrom
            )
        );
        $walletFrom->amount -= $amountForWalletFrom;
        $this->walletRepository->save($walletFrom);

        $walletTo->amount += $amountForWalletTo;
        $this->walletRepository->save($walletTo);
        $this->addHistoryProcessor->process(
            new History(
                $walletTo,
                $amountForWalletTo
            )
        );
        DB::commit();

        $this->logger->info('Creating response');
        return [$walletFrom, $walletTo];
    }

    /**
     * @param Request $request
     * @param Wallet $wallet
     * @return int
     */
    protected function convertAmount(Request $request, Wallet $wallet): int
    {
        if ($wallet->currency != $request->getMoney()->getCurrency()) {
            return
                $this->currencyConverter->convert(
                    $request->getMoney()->getAmount(),
                    $request->getMoney()->getCurrency(),
                    $wallet->currency
                );
        }

        return $request->getMoney()->getAmount();
    }
}
