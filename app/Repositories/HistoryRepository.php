<?php

namespace App\Repositories;

use App\Models\History;
use App\Operation\Wallet\History\GetList\Dto\Criteria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(History $history)
    {
        $history->save();
    }

    /**
     * {@inheritdoc}
     */
    public function findByCriteria(Criteria $criteria): LengthAwarePaginator
    {
        $queryBuilder = $this->createQueryBuilder($criteria);

        return $queryBuilder->paginate();
    }

    /**
     * {@inheritdoc}
     */
    public function sumByCriteria(Criteria $criteria): int
    {
        $queryBuilder = $this->createQueryBuilder($criteria);

        $queryBuilder = $queryBuilder->selectRaw('sum(amount)');

        return $queryBuilder->first()->sum;
    }

    /**
     * {@inheritdoc}
     */
    public function sumUsdByCriteria(Criteria $criteria): int
    {
        $queryBuilder = $this->createQueryBuilder($criteria);

        $queryBuilder = $queryBuilder->selectRaw('sum(amount_usd)');

        return $queryBuilder->first()->sum;
    }

    /**
     * {@inheritdoc}
     */
    protected function modelClassName()
    {
        return History::class;
    }

    /**
     * @param Criteria $criteria
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function createQueryBuilder(Criteria $criteria)
    {
        $queryBuilder =
            $this
                ->model
                ->query()
                ->leftJoin('users', 'users.wallet_id', '=', 'history.wallet_id')
                ->where('users.id', '=', $criteria->getUserId());

        if ($criteria->getDateFrom() !== null) {
            $queryBuilder->where('date', '>=', $criteria->getDateFrom());
        }

        if ($criteria->getDateTo() !== null) {
            $queryBuilder->where('date', '<=', $criteria->getDateTo());
        }

        return $queryBuilder;
    }
}