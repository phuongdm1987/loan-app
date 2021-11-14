<?php
declare(strict_types=1);

namespace App\Events;

use App\Models\Repayment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class RepaymentWasCreatedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private Repayment $repayment;

    /**
     * @param Repayment $repayment
     */
    public function __construct(Repayment $repayment)
    {
        $this->repayment = $repayment;
    }

    /**
     * @return Repayment
     */
    public function getRepayment(): Repayment
    {
        return $this->repayment;
    }
}
