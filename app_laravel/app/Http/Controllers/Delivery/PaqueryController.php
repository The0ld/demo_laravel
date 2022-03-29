<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Delivery\PaqueryRequest;
use App\Contracts\AddressEvaluator\AddressEvaluator;

class PaqueryController extends Controller
{
    /**
     * The user repository implementation.
     *
     * @var AddressEvaluator
    */
    protected $addressEvaluator;

    /**
     * Create a new PaqueryController instance.
     *
     * @param  AddressEvaluator $addressEvaluator
     * @return void
    */
    public function __construct(AddressEvaluator $addressEvaluator)
    {
        $this->addressEvaluator = $addressEvaluator;
    }

    /**
     * Evaluate the paquery address.
     *
     * @param  PaqueryRequest $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function index(PaqueryRequest $request)
    {
        try {
            $result = json_decode($this->addressEvaluator->evaluate(json_encode($request->all())));
            return response()->json($result);
        } catch (\Exception $e) {
            Log::critical('Exception PaqueryController: ' . $e);
            return  response()->json(['error_controlado' => $e->getMessage()], 500);
        }
    }
}
