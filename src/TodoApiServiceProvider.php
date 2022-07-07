<?php

namespace mms80\TodoApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TodoApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(class_exists(config("auth.providers.users.model"))){
            class_alias(config("auth.providers.users.model"), 'UserModel');
        }
        Route::middlewareGroup("api-auth", config("config_todo_api.middleware", []));
        $this->loadRoutesFrom(__DIR__.'/../config/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__ . "/../database/migrations" => database_path("migrations"),
        ]);
        $this->publishes([
            __DIR__ . "/../config/config.php" => config_path("config_todo_api.php"),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/config.php", "config_todo_api");
    }

}