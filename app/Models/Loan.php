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

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_PAID = 'PAID';

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
        'user_id' => 'integer',
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

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => self::STATUS_PENDING,
            self::STATUS_APPROVED => self::STATUS_APPROVED,
            self::STATUS_PAID => self::STATUS_PAID,
        ];
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}
