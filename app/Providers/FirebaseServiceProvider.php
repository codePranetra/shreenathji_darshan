<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            $serviceAccountPath = base_path('storage/app/firebase/serviceAccount.json');

            // Initialize Firebase with service account
            return (new Factory)
                ->withServiceAccount($serviceAccountPath);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
