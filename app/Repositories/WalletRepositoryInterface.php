<?php

namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Wallet;

interface WalletRepositoryInterface
{
    /**
     * @param Wallet $wallet
     * @return void
     */
    public function save(Wallet $wallet);

    /**
     * @param int $walletId
     * @return Wallet
     * @throws EntityNotFoundException
     */
    public function findOne(int $walletId): Wallet;
}
