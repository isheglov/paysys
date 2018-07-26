<?php

namespace App\Repositories;

use App\Models\History;
use App\Operation\Wallet\History\GetList\Dto\Criteria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface HistoryRepositoryInterface
{
    /**
     * @param History $history
     * @return void
     */
    public function save(History $history);

    /**
     * @param Criteria $criteria
     * @return LengthAwarePaginator
     */
    public function findByCriteria(Criteria $criteria): LengthAwarePaginator;
}
