<?php

namespace App\Repositories;

use App\Models\Rate;

final class RateRepository extends BaseRepository implements RateRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(Rate $rate)
    {
        $rate->save();
    }

    /**
     * {@inheritdoc}
     */
    protected function modelClassName()
    {
        return Rate::class;
    }
}