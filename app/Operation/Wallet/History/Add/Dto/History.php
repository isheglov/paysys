<?php

namespace App\Operation\Wallet\History\Add\Dto;

use App\Models\Wallet;

class History
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $amountUsd;

    /**
     * @param Wallet $wallet
     * @param int $amount
     * @param int $amountUsd
     */
    public function __construct(Wallet $wallet, int $amount, int $amountUsd)
    {
        $this->wallet = $wallet;
        $this->amount = $amount;
        $this->amountUsd = $amountUsd;
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getAmountUsd(): int
    {
        return $this->amountUsd;
    }
}
