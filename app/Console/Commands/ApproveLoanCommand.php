<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\Loan\ApproveLoanJob;
use App\Models\Loan;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class ApproveLoanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:change-status-to-approved
        {loanId=0 : The ID of the loan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command approved loan';

    /**
     *
     */
    public function handle(): void
    {
        $this->info('Start the command');
        $this->info('Get loans');
        $loans = $this->getPendingLoans();

        $this->withProgressBar($loans, function (Loan $loan) {
            $this->info('Loan id: ' . $loan->id . ' had approved.');
            dispatch_sync(new ApproveLoanJob($loan));
        });
        $this->info('The command was successful!');
    }

    /**
     * @return Collection
     */
    private function getPendingLoans(): Collection
    {
        $loanId = (int)$this->argument('loanId');
        $queryBuilder = Loan::where('status', Loan::STATUS_PENDING);

        if ($loanId > 0) {
            $queryBuilder->where('id', $loanId);
        }

        return $queryBuilder->get();
    }
}
