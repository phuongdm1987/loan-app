<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 *
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'amount' => $this->faker->numberBetween(100000, 10000000),
            'term' => Arr::random(array_keys(Loan::getTerms())),
            'status' => Loan::STATUS_PENDING,
        ];
    }
}
