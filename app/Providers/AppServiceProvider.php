<?php

namespace App\Providers;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        Carbon::setLocale('id');

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Bagikan data kontak aktif ke semua view layout homepage
        View::composer('layouts.homepage.*', function ($view) {
            $footerContact = Contact::where('is_active', true)->first();
            $view->with('footerContact', $footerContact);
        });
    }
}
