<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Jobs\Authentication\LoginJob;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Login
     *
     * The API authenticate and return access token.
     *
     * @group Authentication
     *
     * @response {"statusCode": 200, "data": {"accessToken": "your token key", "tokenType": "Bearer"}}
     * @response 422 {"message": "The given data was invalid.", "errors": {"email": ["These credentials do not match our records."]}}
     *
     * @unauthenticated
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = $this->dispatchSync(new LoginJob($request->email, $request->password));

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'statusCode' => 200,
            'data' => [
                'accessToken' => $tokenResult,
                'tokenType' => 'Bearer',
            ],
        ]);
    }
}
