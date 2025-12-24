<?php

namespace App\Providers;

use App\Interfaces\User\UserRepositoryInterface as UserUserRepositoryInterface;
use App\Interfaces\Meeting\MeetingRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\MeetingRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserUserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MeetingRepositoryInterface::class, MeetingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
