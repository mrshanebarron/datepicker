<?php

namespace MrShaneBarron\Datepicker;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\Datepicker\View\Components\Datepicker;
use Livewire\Livewire;

class DatepickerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sb-datepicker.php', 'sb-datepicker');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sb-datepicker');

        $this->publishes([
            __DIR__.'/../config/sb-datepicker.php' => config_path('sb-datepicker.php'),
        ], 'sb-datepicker-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/sb-datepicker'),
        ], 'sb-datepicker-views');

        // Register Blade component
        $this->loadViewComponentsAs('ld', [
            Datepicker::class,
        ]);

        // Register Livewire component if Livewire is installed
        if (class_exists(Livewire::class)) {
            Livewire::component('sb-datepicker', \MrShaneBarron\Datepicker\Livewire\Datepicker::class);
        }
    }
}
