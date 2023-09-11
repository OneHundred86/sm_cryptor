<?php


namespace Oh86\SmCryptor\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Cryptor
 * @package Oh86\SmCryptor\Facades
 * @method \Oh86\SmCryptor\Cryptor driver(?string $driver)
 * @method string sm3(string $text)
 * @method string hmacSm3(string $text)
 * @method string sm4Encrypt(string $text)
 * @method string sm4Decrypt(string $cipherText)
 */
class Cryptor extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Oh86\SmCryptor\SmCryptorManager::class;
    }
}
