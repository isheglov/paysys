<?php

namespace App\Operation\Wallet\Charge;

use App\Dto\ErroneousResponse;
use App\Exceptions\EntityNotFoundException;
use App\Models\Wallet;
use App\Operation\Wallet\Charge\Dto\Request;
use App\Operation\Wallet\History\Add\Dto\History;
use App\Operation\Wallet\History\Add\ProcessorInterface;
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
            $this->logger->info('Finding wallet');
            $wallet = $this->findWallet($request->getWalletId());
        } catch (EntityNotFoundException $e) {
            $this->logger->error(sprintf("Wallet with id: '%s' not found", $request->getWalletId()), ['e' => $e]);
            return [];
        }

        $this->logger->info('Checking amount not to much');
        if ($wallet->amount + $request->getAmount() >= self::MAX_WALLET_CAPACITY) {
            return new ErroneousResponse('Amount is to big');
        }

        DB::beginTransaction();

        $this->logger->info('Charging wallet');
        $this->chargeWallet($request->getAmount(), $wallet);

        $this->logger->info('Saving history');
        $this->addHistoryProcessor->process(
            new History(
                $wallet,
                $request->getAmount()
            )
        );

        $this->logger->info('Saving wallet');
        $this->saveWallet($wallet);

        DB::commit();

        $this->logger->info('Returning response');
        return $wallet;
    }

    /**
     * @param int $walletId
     * @return Wallet
     * @throws EntityNotFoundException
     */
    private function findWallet(int $walletId): Wallet
    {
        return $this->walletRepository->findOne($walletId);
    }

    /**
     * @param int $amount
     * @param Wallet $wallet
     * @return void
     */
    private function chargeWallet(int $amount, Wallet $wallet)
    {
        $wallet->amount += $amount;
    }

    /**
     * @param Wallet $wallet
     * @return void
     */
    protected function saveWallet(Wallet $wallet)
    {
        $this->walletRepository->save($wallet);
    }
}
