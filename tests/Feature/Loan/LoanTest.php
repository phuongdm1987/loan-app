<?php
declare(strict_types=1);

namespace Tests\Feature\Loan;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 *
 */
class LoanTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     */
    public function test_can_get_list_loans(): void
    {
        $user = User::factory()->create();
        Loan::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get('/api/loans');

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
    public function test_can_request_loan(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/loans', [
                'amount' => 500000,
                'term' => 1,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('statusCode')
                ->has('data.id')
                ->where('data.amount', 500000)
                ->where('data.term', 1)
                ->where('data.status', 'PENDING')
                ->has('data.createdAt')
            );
    }
}
