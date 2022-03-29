<?php

namespace App\Services\AddressEvaluator;

use App\Classes\GoogleCoords;
use App\Contracts\AddressEvaluator\AddressEvaluator;

class ManualEvaluator implements AddressEvaluator {

    public function evaluate(string $request): String {

        $request = json_decode($request);

        $origin_address = "{$request->remitente->provincia}, {$request->remitente->localidad}, {$request->remitente->direccion}";
        $destination_address = "{$request->destinatario->provincia}, {$request->destinatario->localidad}, {$request->destinatario->direccion}";

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
