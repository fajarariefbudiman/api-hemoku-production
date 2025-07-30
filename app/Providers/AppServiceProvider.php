<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
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
            $dbPath = '/database/database.sqlite';

            if (!file_exists($dbPath)) {
                File::put($dbPath, '');
                chmod($dbPath, 0664);
            }

            config(['database.connections.sqlite.database' => $dbPath]);

            DB::purge('sqlite');
            DB::reconnect('sqlite');

            try {
                $tablesExist = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");

                if (empty($tablesExist)) {
                    Log::info('Running migrations...');
                    Artisan::call('migrate', ['--force' => true]);

                    Log::info('Running seeders...');
                    Artisan::call('db:seed', ['--force' => true]);

                    Log::info('Database setup completed successfully');
                } else {
                    Log::info('Database already exists, skipping migration and seeding');
                }
            } catch (\Exception $e) {
                Log::error('Database setup error: ' . $e->getMessage());
            }
        }
    }
}
