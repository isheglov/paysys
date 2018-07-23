<?php

namespace App\Repositories;

use App\Models\History;

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
    protected function modelClassName()
    {
        return History::class;
    }
}