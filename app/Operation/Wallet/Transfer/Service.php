<?php

namespace App\Operation\Wallet\Transfer;

use App\Dto\ErroneousResponse;
use App\Exceptions\EntityNotFoundException;
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
     * @param WalletRepositoryInterface $walletRepository
     * @param ProcessorInterface $addHistoryProcessor
     * @param LoggerInterface $logger
     */
    public function __construct(
        WalletRepositoryInterface $walletRepository,
        ProcessorInterface $addHistoryProcessor,
        LoggerInterface $logger
    ) {
        $this->setLogger($logger);

        $this->walletRepository = $walletRepository;
        $this->addHistoryProcessor = $addHistoryProcessor;
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
        } catch (EntityNotFoundException $e) {
            $errorMessage = sprintf("WalletFrom with id: '%s' not found", $request->getWalletFromId());

            $this->logger->error($errorMessage, ['e' => $e]);
            return new ErroneousResponse($errorMessage);
        }

        try {
            $this->logger->info('Finding wallet from');
            $walletTo = $this->walletRepository->findOne($request->getWalletToId());
        } catch (EntityNotFoundException $e) {
            $errorMessage = sprintf("WalletTo with id: '%s' not found", $request->getWalletToId());

            $this->logger->error($errorMessage, ['e' => $e]);
            return new ErroneousResponse($errorMessage);
        }

        // в бр
        $this->logger->info('Checking amount enough');
        if ($walletFrom->amount < $request->getAmount()) {
            return new ErroneousResponse('Not enough money');
        }

        $this->logger->info('Checking amount not to much');
        if ($walletTo->amount + $request->getAmount() >= self::MAX_WALLET_CAPACITY) {
            return new ErroneousResponse('Amount is to big');
        }

        DB::beginTransaction();
        $this->addHistoryProcessor->process(
            new History(
                $walletFrom,
                -1*$request->getAmount(),
                -1*$request->getAmount())
        );
        $walletFrom->amount -= $request->getAmount();
        $this->walletRepository->save($walletFrom);

        $walletTo->amount += $request->getAmount();
        $this->walletRepository->save($walletTo);
        $this->addHistoryProcessor->process(
            new History(
                $walletTo,
                $request->getAmount(),
                $request->getAmount())
        );
        DB::commit();

        $this->logger->info('Creating response');
        return [$walletFrom, $walletTo];
    }
}
