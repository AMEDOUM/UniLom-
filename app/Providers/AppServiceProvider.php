<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Actualite;
use App\Policies\ActualitePolicy;

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
        // Enregistrer les policies
        $this->registerPolicies();
    }

    /**
     * Register the policies for authorization
     */
    protected function registerPolicies()
    {
        \Illuminate\Support\Facades\Gate::policy(Actualite::class, ActualitePolicy::class);
    }
}
