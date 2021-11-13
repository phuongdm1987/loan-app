<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Resources\LoanResource;
use App\Jobs\Loan\StoreLoanJob;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class LoanController extends Controller
{
    /**
     * @param StoreLoanRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreLoanRequest $request): JsonResponse
    {
        $loan = $this->dispatchSync(new StoreLoanJob($request->user(), $request->validated()));
        $result = new LoanResource($loan);

        return response()->json([
            'statusCode' => 200,
            'data' => $result->toArray($request),
        ]);
    }
}
