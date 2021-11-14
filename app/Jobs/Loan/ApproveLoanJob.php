<?php
declare(strict_types=1);

namespace App\Jobs\Loan;

use App\Models\Loan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

/**
 *
 */
class ApproveLoanJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    private Loan $loan;

    /**
     * @param Loan $loan
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * @return Loan
     */
    public function handle(): Loan
    {
        if (!$this->loan->isPending()) {
            return $this->loan;
        }

        $this->loan->update([
            'status' => Loan::STATUS_APPROVED,
            'approved_at' => Carbon::now(),
        ]);

        return $this->loan;
    }
}
