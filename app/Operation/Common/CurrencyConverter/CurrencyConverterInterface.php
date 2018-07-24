<?php

namespace App\Operation\Common\CurrencyConverter;

interface CurrencyConverterInterface
{
    /**
     * @param int $amount
     * @param string $from
     * @param string $to
     * @return int
     */
    public function convert(int $amount, string $from, string $to): int;
}
