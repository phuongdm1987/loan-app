<?php
declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 *
 */
class ApproveLoanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_approve_loan(): void
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->artisan('loan:change-status-to-approved ' . $loan->id)
            ->expectsOutput('Start the command')
            ->expectsOutput('Get loans')
            ->expectsOutput('Loan id: ' . $loan->id . ' had approved.')
            ->expectsOutput('The command was successful!')
            ->assertExitCode(0);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_approve_loan_not_pending(): void
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create([
            'user_id' => $user->id,
            'status' => Loan::STATUS_APPROVED,
        ]);

        $this->artisan('loan:change-status-to-approved ' . $loan->id)
            ->expectsOutput('Start the command')
            ->expectsOutput('Get loans')
            ->expectsOutput('The command was successful!')
            ->assertExitCode(0);
    }
}
