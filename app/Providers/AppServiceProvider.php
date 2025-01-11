<?php

namespace App\Providers;

use App\Notifications\Channels\LogChannel;
use App\Repositories\UserSettingRepository;
use App\Repositories\UserSettingRepositoryInterface;
use App\Repositories\VerificationAttemptRepository;
use App\Repositories\VerificationAttemptRepositoryInterface;
use App\Services\UserSettingService;
use App\Services\UserSettingServiceInterface;
use App\Services\VerificationService;
use App\Services\VerificationServiceInterface;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VerificationServiceInterface::class, VerificationService::class);
        $this->app->bind(UserSettingServiceInterface::class, UserSettingService::class);
        $this->app->bind(UserSettingRepositoryInterface::class, UserSettingRepository::class);
        $this->app->bind(VerificationAttemptRepositoryInterface::class, VerificationAttemptRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        resolve(ChannelManager::class)->extend('log', function () {
            return new LogChannel();
        });
    }
}
