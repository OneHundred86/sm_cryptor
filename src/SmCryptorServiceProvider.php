<?php


namespace Oh86\SmCryptor;

use Illuminate\Support\ServiceProvider;

class SmCryptorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmCryptorManager::class, function () {
            return new SmCryptorManager(config("sm_cryptor"));
        });

        $this->app->singleton(Cryptor::class, function (){
            return app(SmCryptorManager::class)->driver();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sm_cryptor.php' => config_path('sm_cryptor.php'),
        ]);
    }
}

