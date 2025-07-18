<?php

namespace Oh86\SmCryptor;

use Illuminate\Contracts\Foundation\Application;
use Oh86\SmCryptor\Impl\LocalCryptor;
use Oh86\SmCryptor\Impl\TelecomCryptor;
use Oh86\SmCryptor\Impl\UnicomCryptor;
use Oh86\SmCryptor\Impl\GDMobileCryptor;
use Closure;

/**
 * @mixin Cryptor
 */
class SmCryptorManager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array<string, Cryptor>
     */
    private array $stores = [];

    /**
     * @var array<string, Cryptor>
     */
    private array $customDriver = [];

    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param array $config
     */
    public function __construct(Application $app, $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function getDefaultDriver(): string
    {
        return $this->config["driver"];
    }

    public function driver(?string $driver = null): Cryptor
    {
        $driver ??= $this->getDefaultDriver();

        if (!($entity = $this->stores[$driver] ?? null)) {
            if ($callback = $this->customDriver[$driver] ?? null) {
                $entity = $callback($this->app, $this->config[$driver]);
            } else {
                $entity = $this->resolve($driver);
            }

            $this->stores[$driver] = $entity;
        }

        return $entity;
    }

    public function resolve(string $driver = null): Cryptor
    {
        if ($driver == "local") {
            return new LocalCryptor($this->config[$driver]);
        } elseif ($driver == "telecom") {
            return new TelecomCryptor($this->config[$driver]);
        } elseif ($driver == "unicom") {
            return new UnicomCryptor($this->config[$driver]);
        } elseif ($driver == "gdmobile") {
            return new GDMobileCryptor($this->config[$driver]);
        }

        throw new \RuntimeException("不支持该驱动: $driver");
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string  $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customDriver[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
