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

        if ($from != 'usd') {
            return $amount * $this->rateRepository->findByCurrency($from)->curr;
        }

        if ($to != 'usd') {
            return $amount / $this->rateRepository->findByCurrency($to)->curr;
        }
    }
}
