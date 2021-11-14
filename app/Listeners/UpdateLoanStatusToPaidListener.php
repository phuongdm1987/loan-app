<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\RepaymentWasCreatedEvent;
use App\Jobs\Loan\PaidLoanJob;

/**
 *
 */
class UpdateLoanStatusToPaidListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param RepaymentWasCreatedEvent $event
     */
    public function handle(RepaymentWasCreatedEvent $event): void
    {
        dispatch_sync(new PaidLoanJob($event->getRepayment()->loan));
    }
}
