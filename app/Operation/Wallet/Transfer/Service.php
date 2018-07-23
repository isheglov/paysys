<?php

namespace App\Operation\Wallet\Transfer;

use App\Dto\ErroneousResponse;
use App\Exceptions\EntityNotFoundException;
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
        //write history
        $walletFrom->amount -= $request->getAmount();
        $this->walletRepository->save($walletFrom);

        $walletTo->amount += $request->getAmount();
        $this->walletRepository->save($walletTo);
        //write history
        DB::commit();

        $this->logger->info('Creating response');
        return [$walletFrom, $walletTo];
    }
}
