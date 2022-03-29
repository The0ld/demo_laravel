<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Delivery\{ManualController, PaqueryController};
use App\Contracts\AddressEvaluator\AddressEvaluator;
use App\Services\AddressEvaluator\{
    ManualEvaluator,
    PaqueryEvaluator
};

class AddressEvaluatorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->ContextManual();
        $this->ContextPaquery();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Context binding ManualEvaluator
     *
     * @return void
    */
    public function ContextManual()
    {
        $this->app->when(ManualController::class)
                  ->needs(AddressEvaluator::class)
                  ->give(ManualEvaluator::class);
    }

    /**
     * Context binding PaqueryEvaluator
     *
     * @return void
    */
    public function ContextPaquery()
    {
        $this->app->when(PaqueryController::class)
                  ->needs(AddressEvaluator::class)
                  ->give(PaqueryEvaluator::class);
    }
}
