<?php

namespace BajakLautMalaka\PmiAdmin;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class PmiAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(RouteRegistrar $routeRegistrar, Factory $factory)
    {
        $this->loadConfig();
        $this->loadFactories($factory);
        $this->loadMigrations();
        $this->loadResponseMacros();
        $this->loadRoutes($routeRegistrar);
        $this->loadViews();
        $this->mergeAuthConfig();
    }
    
    private function loadConfig(): void
    {
        $path = __DIR__.'/../config/admin.php';
        $this->mergeConfigFrom($path, 'admin');
        
    }
    
    private function loadFactories(Factory $factory): void
    {
        if ($this->app->runningInConsole()) {
            $factory->load(__DIR__.'/../database/factories');
        }
    }
    
    private function loadMigrations(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
    
    private function loadResponseMacros(): void
    {
        if (!$this->app->runningInConsole()) {
            $this->makeResponseJsendSuccess();
            $this->makeResponseJsendFail();
            $this->makeResponseJsendError();
        }
    }
    
    private function loadViews(): void
    {
        $path = __DIR__.'/../resources/views';
        $this->loadViewsFrom($path, 'admin');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $path => resource_path('views/vendor/admin'),
            ], 'admin:views');
        }
    }
    
    private function makeResponseJsendSuccess() {
        Response::macro('success', function ($data) {
            return Response::make([
                'status'=>'success',
                'data'=>$data
            ]);
        });
    }
    
    private function makeResponseJsendFail() {
        Response::macro('fail', function ($data) {
            return Response::make([
                'status'=>'fail',
                'data'=>$data
            ]);
        });
    }
    
    private function makeResponseJsendError() {
        Response::macro('error', function ($message, $data=[]) {
            $response = [
                'status'=>'error',
                'message'=>$message
            ];

            if($data) {
                $response['data'] = $data;
            }

            return Response::make($response);
        });
    }
    
    private function loadRoutes(RouteRegistrar $routeRegistrar): void
    {
        $routeRegistrar->prefix('api')
                ->namespace('BajakLautMalaka\PmiAdmin\Http\Controllers')
                ->middleware(['api'])
                ->group(function () {
                    $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
                });
                
        $routeRegistrar->prefix(config('admin.prefix', 'admin'))
                ->namespace('BajakLautMalaka\PmiAdmin\Http\Controllers')
                ->middleware(['web'])
                ->group(function () {
                    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
                });
    }
    
    private function mergeAuthConfig(): void
    {
        $default = config('auth', []);
        $custom = require __DIR__ . '/../config/auth.php';
        
        $auth = [];
        foreach ($default as $key => $value) {
            $auth[$key] = $value;
            if (isset($custom[$key])) {
                $auth[$key] = array_merge($value, $custom[$key]);
            }
        }
        
        config(['auth'=>$auth]);
    }
}
