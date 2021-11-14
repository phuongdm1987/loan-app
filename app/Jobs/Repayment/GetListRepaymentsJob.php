<?php
declare(strict_types=1);

namespace App\Jobs\Repayment;

use App\Models\Repayment;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class GetListRepaymentsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    private User $contextUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $contextUser)
    {
        $this->contextUser = $contextUser;
    }

    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        return Repayment::where('user_id', $this->contextUser->id)->get();
    }
}
