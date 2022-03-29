<?php

namespace App\Services\AddressEvaluator;

use App\Classes\GoogleCoords;
use App\Contracts\AddressEvaluator\AddressEvaluator;
use Illuminate\Database\Eloquent\Collection;

class PaqueryEvaluator implements AddressEvaluator {

    public function evaluate(string $request): String {

        $request = json_decode($request);

        $origin_address = $request->schedule_origin->shipping_address;
        $destination_address = $request->schedule_destination->shipping_address;

        $googleCoords = new GoogleCoords();
        $origin_evaluation = $googleCoords->getCoordinate($origin_address);
        $destination_evaluation = $googleCoords->getCoordinate($destination_address);

        $coords = json_encode([
            "coords_origin"      => $origin_evaluation ? $origin_evaluation : null,
            "coords_destination" => $destination_evaluation ? $destination_evaluation : null
        ]);

        return $coords;
    }
}
