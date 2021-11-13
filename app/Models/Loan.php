<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Loan extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'amount',
        'term',
        'status',
        'approved_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'amount' => 'double',
        'term' => 'integer',
        'approved_at' => 'datetime',
    ];

    /**
     * @return array
     */
    public static function getTerms(): array
    {
        return [
            1 => __('month', ['number' => 1]),
            3 => __('month', ['number' => 3]),
            6 => __('month', ['number' => 6]),
            9 => __('month', ['number' => 9]),
            12 => __('month', ['number' => 12]),
            24 => __('month', ['number' => 24]),
            36 => __('month', ['number' => 36]),
        ];
    }
}
