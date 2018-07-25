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
     * @param Wallet $wallet
     * @param int $amount
     */
    public function __construct(Wallet $wallet, int $amount)
    {
        $this->wallet = $wallet;
        $this->amount = $amount;
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
}
