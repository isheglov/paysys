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

    /**
     * @param int $amount
     * @param string $from
     * @return int
     */
    public function convertToUsd(int $amount, string $from): int;

    /**
     * @param int $amount
     * @param string $to
     * @return int
     */
    public function convertFromUsd(int $amount, string $to): int;
}
