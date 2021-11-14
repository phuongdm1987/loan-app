<?php
declare(strict_types=1);

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * @return string[][]
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'The email of user.',
                'example' => 'phuongdm1987@gmail.com',
            ],
            'password' => [
                'description' => 'The password of user.',
                'example' => 'password',
            ],
        ];
    }
}
