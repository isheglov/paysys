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

        return $queryBuilder->paginate();
    }

    /**
     * {@inheritdoc}
     */
    protected function modelClassName()
    {
        return History::class;
    }
}