<?php

namespace App\Contracts\AddressEvaluator;

interface AddressEvaluator
{
    public function evaluate(string $request): String;
}
