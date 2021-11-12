<?php
declare(strict_types=1);

namespace App\Jobs\Authentication;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class LoginJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    private string $email;
    private string $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return User
     * @throws ValidationException
     */
    public function handle(): User
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user;
    }
}
