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
    public function findByCurrency(string $currency): Rate
    {
        return
            $this
                ->model
                ->query()
                    ->where('date', '=', 'NOW()')
                    ->where('curr', '=', trim(strtolower($currency)))
                    ->first()
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function modelClassName()
    {
        return Rate::class;
    }
}