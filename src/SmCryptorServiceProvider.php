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
        $this->app->singleton(Cryptor::class, function () {
            return Factory::createCryptor(config("sm_cryptor.driver"));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sm_cryptor.php' => config_path('sm_cryptor.php'),
        ]);
    }
}

