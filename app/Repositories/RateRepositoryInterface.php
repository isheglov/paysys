<?php

namespace App\Repositories;

use App\Models\Rate;

interface RateRepositoryInterface
{
    /**
     * @param Rate $rate
     * @return void
     */
    public function save(Rate $rate);
}
