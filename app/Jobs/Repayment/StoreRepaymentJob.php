<?php
declare(strict_types=1);

namespace App\Jobs\Repayment;

use App\Events\RepaymentWasCreatedEvent;
use App\Models\Repayment;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class StoreRepaymentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    private User $contextUser;
    private array $dataInput;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $contextUser, array $dataInput)
    {
        $this->contextUser = $contextUser;
        $this->dataInput = $dataInput;
    }

    /**
     *
     */
    public function handle()
    {
        $this->dataInput['user_id'] = $this->contextUser->id;

        $repayment = DB::transaction(function () {
            $repayment = Repayment::create($this->dataInput);
            event(new RepaymentWasCreatedEvent($repayment));

            return $repayment;
        });

        return $repayment->fresh();
    }
}
