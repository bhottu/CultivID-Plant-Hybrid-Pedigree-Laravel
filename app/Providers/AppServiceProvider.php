<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use App\Models\GoogleSetting;
use App\Models\GoogleAdsense;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
         $settings = Setting::first();

         ## IF YOU RUN ON LOCALHOST, DON'T REMOVE THIS COMMENT ##
          #if (app()->environment('production') || app()->environment('local')) {
         #    URL::forceScheme('https');
         # }
        // ## IF YOU RUN ON LOCALHOST, DON'T REMOVE THIS COMMENT ##

         $googleSettings = GoogleSetting::first();
         if ($googleSettings) {
           config([
              'services.google.client_id' => $googleSettings->google_client_id,
              'services.google.client_secret' => $googleSettings->google_client_secret,
             'services.google.redirect' => $googleSettings->google_redirect_uri,
         ]);
         }

         View::composer('*', function ($view) {
             $adsense = GoogleAdsense::first();
             $view->with('adsense', $adsense);
         });

         View::share('settings', $settings);


    }

    
}
