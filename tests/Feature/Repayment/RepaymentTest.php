<?php
declare(strict_types=1);

namespace Tests\Feature\Repayment;

use App\Models\Loan;
use App\Models\Repayment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 *
 */
class RepaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     */
    public function test_can_get_list_repayments(): void
    {
        $user = User::factory()->create();
        Repayment::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get('/api/repayments');

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('statusCode')
                ->has('data', 3)
            );
    }

    /**
     *
     */
    public function test_can_request_repayment(): void
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create([
            'user_id' => $user->id,
            'status' => Loan::STATUS_APPROVED
        ]);

        $response = $this
            ->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/repayments', [
                'loan_id' => $loan->id,
                'amount' => $loan->amount,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('statusCode')
                ->has('data.id')
                ->where('data.amount', $loan->amount)
                ->where('data.loanId', $loan->id)
                ->has('data.createdAt')
            );
    }
}
