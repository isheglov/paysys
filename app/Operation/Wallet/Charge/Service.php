<?php

namespace App\Operation\Wallet\Charge;

use App\Exceptions\EntityNotFoundException;
use App\Models\Wallet;
use App\Operation\Wallet\Charge\Dto\Request;
use App\Repositories\WalletRepositoryInterface;
use App\Service\ServiceInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

final class Service implements ServiceInterface
{
    use LoggerAwareTrait;

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @param WalletRepositoryInterface $walletRepository
     * @param LoggerInterface $logger
     */
    public function __construct(WalletRepositoryInterface $walletRepository, LoggerInterface $logger)
    {
        $this->setLogger($logger);

        $this->walletRepository = $walletRepository;
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
            return null;
        }

        $this->logger->info('Charging wallet');
        $this->chargeWallet($request->getAmount(), $wallet);

        $this->logger->info('Saving wallet');
        $this->saveWallet($wallet);

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
