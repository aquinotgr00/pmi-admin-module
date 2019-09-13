<?php

namespace BajakLautMalaka\PmiAdmin;

use Illuminate\Support\ServiceProvider;
use Berkayk\OneSignal\OneSignalClient;
use Illuminate\Support\Facades\Log;

class PmiPushNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(OneSignalClient::class, function ($app) {
            $pushNotificationAppId = config('admin.push_notification.app_id',env('ONESIGNAL_APP_ID'));
            $pushNotificationRestApiKey = config('admin.push_notification.rest_api_key',env('ONESIGNAL_REST_API_KEY'));
            return new OneSignalClient($pushNotificationAppId, $pushNotificationRestApiKey, $pushNotificationRestApiKey);
        });
    }
}
