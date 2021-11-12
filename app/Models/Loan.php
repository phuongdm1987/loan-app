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
        'status',
        'approved_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'approved_at' => 'datetime',
    ];
}
