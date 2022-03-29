<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class GoogleCoords {

    private $urlAutocomplete;
    private $urlGeocoding;
    private $googleKey;

    public function __construct() {
        $this->urlAutocomplete = env('URL_GOOGLE_AUTOCOMPLETE');
        $this->urlGeocoding = env('URL_GOOGLE_GEOCODING');
        $this->googleKey = env('GOOGLE_MAPS_KEY');
    }

    public function getCoordinate(string $search): ?String {
        $autocomplete = Http::get("{$this->urlAutocomplete}key={$this->googleKey}&input={$search}");
        $autocomplete = json_decode($autocomplete->body());

        if (count($autocomplete->predictions) == 1) {
            $geocoding = Http::get("{$this->urlGeocoding}key={$this->googleKey}&place_id={$autocomplete->predictions[0]->place_id}");
            $geocoding = json_decode($geocoding->body());

            $coords = json_encode([
                "lat" => $geocoding->results[0]->geometry->location->lat,
                "lng" => $geocoding->results[0]->geometry->location->lng,
            ]);

            return $coords;
        }

        return null;
    }
}
