<?php
declare(strict_types=1);

namespace App\Http\Requests\Repayment;

use App\Models\Loan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreRepaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $loan = null;

        if ($this->has('loan_id')) {
            $loan = Loan::find($this->get('loan_id'));
        }

        return [
            'loan_id' => [
                'required',
                'integer',
                Rule::exists('loans', 'id')
                    ->where('status', Loan::STATUS_APPROVED),
            ],
            'amount' => ['required', 'integer', Rule::in([$loan?->amount])],
        ];
    }

    /**
     * @return string[][]
     */
    public function bodyParameters(): array
    {
        return [
            'loan_id' => [
                'description' => 'The id of approved loan need to repayment.',
                'example' => 1,
            ],
            'amount' => [
                'description' => 'The amount must be equal with loan\'s amount.',
                'example' => 500000,
            ],
        ];
    }
}
