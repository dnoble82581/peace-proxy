<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('cache', function ($path, $cacheTime = 31536000) {
            return response()->file($path, [
                'Cache-Control' => 'public, max-age='.$cacheTime,
                'Expires' => gmdate('D, d M Y H:i:s', time() + $cacheTime).' GMT',
            ]);
        });

        Cashier::calculateTaxes();
        Cashier::useCustomerModel(Tenant::class);

    }
}
