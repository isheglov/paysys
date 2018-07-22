<?php

namespace App\Operation\User\Create;

use App\Models\User;
use App\Models\Wallet;
use App\Repositories\UserRepositoryInterface;
use App\Service\ServiceInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

final class Service implements ServiceInterface
{
    use LoggerAwareTrait;

    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * @param UserRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(UserRepositoryInterface $repository, LoggerInterface $logger)
    {
        $this->setLogger($logger);

        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function behave($request)
    {
        $this->logger->info('Creating wallet');
        $wallet = $this->createWallet($request);

        $this->logger->info('Creating user');
        $user = $this->creatingUser($request, $wallet);

        $this->logger->info('Saving user');
        $this->repository->save($user);

        $this->logger->info('Returning response');
        return $user;
    }

    /**
     * @param $request
     * @return Wallet
     */
    protected function createWallet($request): Wallet
    {
        $wallet = new Wallet();

        $wallet->currency = $request->get('currency');
        $wallet->amount = 0;

        $wallet->save();

        return $wallet;
    }

    /**
     * @param $request
     * @param $wallet
     * @return User
     */
    protected function creatingUser($request, $wallet): User
    {
        $user = new User();

        $user->name = $request->get('name');
        $user->country = $request->get('country');
        $user->city = $request->get('city');
        $user->wallet_id = $wallet->id;

        return $user;
    }
}
