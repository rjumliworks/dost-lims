<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use App\Listeners\LoginFailed;
use App\Listeners\LoginSuccessful;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        Event::listen(
            LoginSuccessful::class,
            LoginFailed::class
        );

        if (App::environment('production')) {

         foreach ([
            'migrate:fresh',
            'db:wipe',
            'db:seed',
            'migrate:refresh',
            'migrate:reset',
            'migrate:rollback',
            'migrate:customers',
            'migrate:tsrs',
            'migrate:finance'
        ] as $command) {

            Artisan::command($command, function () use ($command) {
                $this->error("The [$command] command is disabled in production.");
            });

        }
            // Artisan::command('migrate:fresh', function () {
            //     $this->error('-');
            // });

            // Artisan::command('db:wipe', function () {
            //     $this->error('-');
            // });

            // Artisan::command('migrate:fresh --seed', function () {
            //     $this->error('-');
            // });

            // Artisan::command('migrate:customers', function () {
            //     $this->error('-');
            // });

            // Artisan::command('migrate:tsrs', function () {
            //     $this->error('-');
            // });
        }
    }
}
