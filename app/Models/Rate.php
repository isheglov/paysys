<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $curr
 * @property string $rate
 * @property DateTime $date
 */
final class Rate extends Model
{
    /**
     * @var string
     */
    protected $table = 'rates';

    /**
     * @var string
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'curr',
        'rate',
        'date',
    ];
}
