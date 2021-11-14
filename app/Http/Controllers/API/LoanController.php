<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Resources\LoanResource;
use App\Jobs\Loan\GetListLoansJob;
use App\Jobs\Loan\StoreLoanJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class LoanController extends Controller
{
    /**
     * List Loans
     *
     * Get all loans of current user
     *
     * @group Loan management
     *
     * @response {"statusCode": 200, "data": [{"id": 1, "amount": 500000, "term": 12, "status": "PENDING", "createdAt": "2021-11-14"}, {"id": 2, "amount": 300000, "term": 16, "status": "PENDING", "createdAt": "2021-11-14"}]}
     *
     * @param StoreLoanRequest $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $loans = $this->dispatchSync(new GetListLoansJob($request->user()));
        $result = LoanResource::collection($loans);

        return response()->json([
            'statusCode' => 200,
            'data' => $result->toArray($request),
        ]);
    }

    /**
     * Store a new Loan
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
    public function store(StoreLoanRequest $request): JsonResponse
    {
        $loan = $this->dispatchSync(new StoreLoanJob($request->user(), $request->validated()));
        $result = new LoanResource($loan);

        return response()->json([
            'statusCode' => 200,
            'data' => $result->toArray($request),
        ]);
    }
}
