<?php

namespace App\Operation\Wallet\Transfer\Dto;

class Request
{
    /**
     * @var int
     */
    private $walletFromId;

    /**
     * @var int
     */
    private $walletToId;

    /**
     * @var int
     */
    private $amount;

    /**
     * @param int $walletFromId
     * @param int $walletToId
     * @param int $amount
     */
    public function __construct(int $walletFromId, int $walletToId, int $amount)
    {
        $this->walletFromId = $walletFromId;
        $this->walletToId = $walletToId;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getWalletFromId(): int
    {
        return $this->walletFromId;
    }

    /**
     * @return int
     */
    public function getWalletToId(): int
    {
        return $this->walletToId;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
