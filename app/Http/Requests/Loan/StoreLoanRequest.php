<?php
declare(strict_types=1);

namespace App\Http\Requests\Loan;

use App\Models\Loan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreLoanRequest extends FormRequest
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
        return [
            'amount' => ['required', 'integer'],
            'term' => ['required', Rule::in(array_keys(Loan::getTerms()))],
        ];
    }
}
