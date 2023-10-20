<?php


namespace Oh86\SmCryptor;

use Illuminate\Support\ServiceProvider;
use Oh86\SmCryptor\Commands\GenUnicomSessionKeyContext;

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

        if ($this->app->runningInConsole()){
            $this->commands([
                GenUnicomSessionKeyContext::class,
            ]);
        }
    }
}

