<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Requests\Repayment\StoreRepaymentRequest;
use App\Http\Resources\RepaymentResource;
use App\Jobs\Repayment\GetListRepaymentsJob;
use App\Jobs\Repayment\StoreRepaymentJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class RepaymentController extends Controller
{
    /**
     * List Repayments
     *
     * Get all repayments of current user
     *
     * @group Repayment management
     *
     * @response {"statusCode": 200, "data": [{"id": 1, "loanId": 1, "amount": 500000, "createdAt": "2021-11-14"}, {"id": 2, "loanId": 2, "amount": 300000, "createdAt": "2021-11-14"}]}
     *
     * @param StoreLoanRequest $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $repayments = $this->dispatchSync(new GetListRepaymentsJob($request->user()));
        $result = RepaymentResource::collection($repayments);

        return response()->json([
            'statusCode' => 200,
            'data' => $result->toArray($request),
        ]);
    }

    /**
     * Store a new Repayment
     *
     * Repayment a loan
     *
     * @group Repayment management
     *
     * @response {"statusCode": 200, "data": {"id": 1, "loanId": 1, "amount": 500000, "createdAt": "2021-11-14"}}
     * @response 422 {"message": "The given data was invalid.", "errors": {"loan_id": ["The selected loan id is invalid."]}}
     *
     * @param StoreRepaymentRequest $request
     * @return JsonResponse
     */
    public function store(StoreRepaymentRequest $request): JsonResponse
    {
        $repayment = $this->dispatchSync(new StoreRepaymentJob($request->user(), $request->validated()));
        $result = new RepaymentResource($repayment);

        return response()->json([
            'statusCode' => 200,
            'data' => $result->toArray($request),
        ]);
    }
}
