<?php

namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Wallet;

final class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(Wallet $wallet)
    {
        $wallet->save();
    }

    /**
     * {@inheritdoc}
     */
    public function findOne(int $walletId): Wallet
    {
        $wallet = $this->model->whereId($walletId)->first();

        if ($wallet === null) {
            throw new EntityNotFoundException();
        }

        return $wallet;
    }

    /**
     * {@inheritdoc}
     */
    protected function modelClassName()
    {
        return Wallet::class;
    }
}