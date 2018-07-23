<?php

namespace App\Repositories;

use App\Models\History;

interface HistoryRepositoryInterface
{
    /**
     * @param History $history
     * @return void
     */
    public function save(History $history);
}
