<?php

namespace App\Repositories;

use App\Models\History;
use App\Operation\Wallet\History\GetList\Dto\Criteria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface HistoryRepositoryInterface
{
    /**
     * @param History $history
     * @return void
     */
    public function save(History $history);

    /**
     * @param Criteria $criteria
     * @return Collection
     */
    public function findByCriteria(Criteria $criteria): Collection;

    /**
     * @param Criteria $criteria
     * @return LengthAwarePaginator
     */
    public function findByCriteriaWithPagination(Criteria $criteria): LengthAwarePaginator;

    /**
     * @param Criteria $criteria
     * @return int
     */
    public function sumByCriteria(Criteria $criteria): int;

    /**
     * @param Criteria $criteria
     * @return int
     */
    public function sumUsdByCriteria(Criteria $criteria): int;
}
