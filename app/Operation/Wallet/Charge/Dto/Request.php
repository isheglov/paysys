<?php

namespace App\Operation\Wallet\Charge\Dto;

class Request
{
    /**
     * @var int
     */
    private $walletId;

    /**
     * @var int
     */
    private $amount;

    /**
     * @param int $walletId
     * @param int $amount
     */
    public function __construct(int $walletId, int $amount)
    {
        $this->walletId = $walletId;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getWalletId(): int
    {
        return $this->walletId;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
