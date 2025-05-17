<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
        Vite::prefetch(concurrency: 3);
        Inertia::share([
            // this key makes the avatar URL available as `$page.props.auth.user.avatar_url`
            'auth.user.avatar_url' => function () {
                // Auth::check() returns false if nobody’s logged in
                if (! Auth::check()) {
                    return null;
                }

                // We’ll assume you’ve defined an accessor on User:
                // public function getAvatarUrlAttribute(): string { … }
                return Auth::user()->avatar_url;
            },
        ]);
    }
}
