<?php

namespace App\Operation\Wallet\History\GetList;

use App\Operation\Wallet\History\GetList\Dto\Criteria;
use App\Repositories\HistoryRepositoryInterface;
use App\Service\ServiceInterface;
use Illuminate\Http\Request;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

final class Service implements ServiceInterface
{
    use LoggerAwareTrait;

    /**
     * @var HistoryRepositoryInterface
     */
    private $repository;

    /**
     * @param HistoryRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(HistoryRepositoryInterface $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     * @param Request $request
     */
    public function behave($request)
    {
        $this->logger->info('Creating criteria');
        $criteria = $this->createCriteria($request);

        $this->logger->info('Finding operations');
        $historyListPaginateAware = $this->repository->findByCriteriaWithPagination($criteria);

        $this->logger->info('Creating response');
        return $historyListPaginateAware;
    }

    /**
     * @param Request $request
     * @return Criteria
     */
    private function createCriteria(Request $request): Criteria
    {
        return
            new Criteria(
                $request->input('userId'),
                $request->input('dateFrom'),
                $request->input('dateTo')
            );
    }
}
