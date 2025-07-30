<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Review;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Force HTTPS only when using ngrok or in production
        if(str_contains(request()->getHost(), 'ngrok') || env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
        
        // Share pending reviews count with all views
        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->is_admin) {
                $pendingReviewsCount = Review::where('status', 'pending')->count();
                $view->with('pendingReviewsCount', $pendingReviewsCount);
            }
        });
    }
}