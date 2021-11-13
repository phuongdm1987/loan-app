<?php
declare(strict_types=1);

namespace App\Jobs\Loan;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class StoreLoanJob implements ShouldQueue
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
     * @return Loan
     */
    public function handle(): Loan
    {
        $this->dataInput['user_id'] = $this->contextUser->id;
        $loan = Loan::create($this->dataInput);

        return $loan->fresh();
    }
}
