<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        if (app()->environment('production', 'staging')) {
            $dbPath = '/tmp/database.sqlite';

            if (!file_exists($dbPath)) {
                File::put($dbPath, '');
            }
            config(['database.connections.sqlite.database' => $dbPath]);
        }
    }
}
