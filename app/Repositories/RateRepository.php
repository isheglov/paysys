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
                        ->where('date', '=', date('Y-m-d'))
                        ->where('curr', '=', trim(strtolower($currency)))
                        ->get()
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