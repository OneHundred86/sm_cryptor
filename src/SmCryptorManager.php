<?php


namespace Oh86\SmCryptor;


use Oh86\SmCryptor\Impl\LocalCryptor;
use Oh86\SmCryptor\Impl\TelecomCryptor;
use Oh86\SmCryptor\Impl\UnicomCryptor;

/**
 * @mixin Cryptor
 */
class SmCryptorManager
{
    private array $config;

    /**
     * @var array<string => Cryptor>
     */
    private array $stores = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getDefaultDriver(): string
    {
        return $this->config["driver"];
    }

    public function driver(?string $driver = null): Cryptor
    {
        $driver = $driver ?? $this->getDefaultDriver();

        if(!($entity = $this->stores[$driver] ?? null)){
            $entity = $this->resolve($driver);
            $this->stores[$driver] = $entity;
        }

        return $entity;
    }

    public function resolve(string $driver = null): Cryptor
    {
        if ($driver == "local"){
            return new LocalCryptor($this->config[$driver]);
        }elseif($driver == "telecom") {
            return new TelecomCryptor($this->config[$driver]);
        }elseif($driver == "unicom"){
            return new UnicomCryptor($this->config[$driver]);
        }

        throw new \RuntimeException("不支持该驱动: $driver");
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
