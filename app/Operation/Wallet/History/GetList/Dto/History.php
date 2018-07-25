<?php

namespace App\Operation\Wallet\History\GetList\Dto;

class History
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $date;

    /**
     * @param int $amount
     * @param string $date
     */
    public function __construct(int $amount, string $date)
    {
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getAmount(): int
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
