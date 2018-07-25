<?php

namespace App\Operation\Common\CurrencyConverter;

use App\Repositories\RateRepositoryInterface;

final class CurrencyConverter implements CurrencyConverterInterface
{
    /**
     * @var RateRepositoryInterface
     */
    private $rateRepository;

    /**
     * @param RateRepositoryInterface $rateRepository
     */
    public function __construct(RateRepositoryInterface $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(int $amount, string $from, string $to): int
    {
        if ($from == $to) {
            return $amount;
        }

        return $this->convertFromUsd($this->convertToUsd($amount, $from), $to);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToUsd(int $amount, string $from): int
    {
        if ($from == 'usd') {
            return $amount;
        }

        return $amount * $this->getRate($from);
    }

    /**
     * {@inheritdoc}
     */
    public function convertFromUsd(int $amount, string $to): int
    {
        if ($to == 'usd') {
            return $amount;
        }

        return $amount / $this->getRate($to);
    }

    /**
     * @param string $currency
     * @return float
     */
    private function getRate(string $currency): float
    {
        return (float) $this->rateRepository->findByCurrency($currency)->rate;
    }
}
