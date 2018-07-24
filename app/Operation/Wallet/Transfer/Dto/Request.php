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
     * @var Money
     */
    private $money;

    /**
     * @param int $walletFromId
     * @param int $walletToId
     * @param Money $money
     */
    public function __construct(int $walletFromId, int $walletToId, Money $money)
    {
        $this->walletFromId = $walletFromId;
        $this->walletToId = $walletToId;
        $this->money = $money;
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
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }
}
