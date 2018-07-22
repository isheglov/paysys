<?php

namespace App\Operation\User\Create;

use App\Models\User;
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
        $this->logger->info('Creating user');
        $user = new User();

        $this->logger->info('Filling user with data from request');
        $user->name = $request->get('name');
        $user->country = $request->get('country');
        $user->city = $request->get('city');
        $user->currency = $request->get('currency');

        $this->logger->info('Saving user');

        $this->repository->save($user);

        $this->logger->info('Returning response');
        return $user;
    }
}
