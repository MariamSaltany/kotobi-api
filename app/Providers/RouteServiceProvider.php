<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(base_path('routes/api.php'));

        Route::middleware(['api','auth:sanctum','role:admin'])
            ->prefix('api/v1/admin')
            ->group(base_path('routes/admin.php'));

        Route::middleware(['api','auth:sanctum', 'role:author'])
            ->prefix('api/v1/author')
            ->group(base_path('routes/author.php'));

        Route::middleware(['api','auth:sanctum', 'role:customer'])
            ->prefix('api/v1/customer')
            ->group(base_path('routes/customer.php'));
    }
}