<?php

namespace App\Providers;

use App\Livewire\Permisos\PermisosTable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;

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
        Password::default(static function (): Password {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->uncompromised();
        });

        Livewire::component('permisos-table', PermisosTable::class);
    }
}
