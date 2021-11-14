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
     * Loan
     *
     * Request a new loan
     *
     * @group Loan management
     *
     * @response {"statusCode": 200, "data": {"id": 1, "amount": 500000, "term": 12, "status": "PENDING", "createdAt": "2021-11-14"}}
     * @response 422 {"message": "The given data was invalid.", "errors": {"amount": ["The amount field is required."]}}
     *
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
