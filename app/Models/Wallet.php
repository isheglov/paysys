<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $amount
 * @property string|null $currency
 */
final class Wallet extends Model
{
    /**
     * @var string
     */
    protected $table = 'wallets';

    /**
     * @var string
     */
    protected $keyType = 'int';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'currency',
    ];
}
