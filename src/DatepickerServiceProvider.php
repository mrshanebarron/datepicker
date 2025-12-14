<?php

namespace MrShaneBarron\Datepicker;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\Datepicker\View\Components\Datepicker;
use Livewire\Livewire;

class DatepickerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ld-datepicker.php', 'ld-datepicker');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ld-datepicker');

        $this->publishes([
            __DIR__.'/../config/ld-datepicker.php' => config_path('ld-datepicker.php'),
        ], 'ld-datepicker-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ld-datepicker'),
        ], 'ld-datepicker-views');

        // Register Blade component
        $this->loadViewComponentsAs('ld', [
            Datepicker::class,
        ]);

        // Register Livewire component if Livewire is installed
        if (class_exists(Livewire::class)) {
            Livewire::component('ld-datepicker', \MrShaneBarron\Datepicker\Livewire\Datepicker::class);
        }
    }
}
