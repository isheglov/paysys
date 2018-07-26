<?php

namespace App\Operation\Wallet\History\GetList\Dto;

class History
{
    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $date;

    /**
     * @param float $amount
     * @param string $date
     */
    public function __construct(float $amount, string $date)
    {
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
}
