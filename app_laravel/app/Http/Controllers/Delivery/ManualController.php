<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\Delivery\ManualRequest;
use App\Contracts\AddressEvaluator\AddressEvaluator;

class ManualController extends Controller
{
    /**
     * The user repository implementation.
     *
     * @var AddressEvaluator
    */
    protected $addressEvaluator;

    /**
     * Create a new ManualController instance.
     *
     * @param  AddressEvaluator $addressEvaluator
     * @return void
    */
    public function __construct(AddressEvaluator $addressEvaluator)
    {
        $this->addressEvaluator = $addressEvaluator;
    }

    /**
     * Evaluate the manual address.
     *
     * @param  ManualRequest $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function index(ManualRequest $request)
    {
        try {
            $result = json_decode($this->addressEvaluator->evaluate(json_encode($request->all())));
            return response()->json($result);
        } catch (\Exception $e) {
            Log::critical('Exception ManualController: ' . $e);
            return response()->json(['error_controlado' => $e->getMessage()], 500);
        }
    }
}
