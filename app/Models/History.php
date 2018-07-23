<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $wallet_id
 * @property DateTime $date
 * @property int $amount
 * @property int $amount_usd
 */
final class History extends Model
{
    /**
     * @var string
     */
    protected $table = 'history';

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
        'wallet_id',
        'date',
        'amount',
        'amount_usd',
    ];
}
