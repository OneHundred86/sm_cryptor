<?php


namespace Oh86\SmCryptor\Facades;


use Illuminate\Support\Facades\Facade;
use Oh86\SmCryptor\SmCryptorManager;

/**
 * Class Cryptor
 * @package Oh86\SmCryptor\Facades
 * @method static SmCryptorManager extend(string $driver, \Closure $callback)
 * @method static \Oh86\SmCryptor\Cryptor driver(?string $driver)
 * @method static string sm3(string $text)
 * @method static string hmacSm3(string $text)
 * @method static string sm4Encrypt(string $text)
 * @method static string sm4Decrypt(string $cipherText)
 * @method static string sm2GenSign(string $text)
 * @method static bool sm2VerifySign(string $text, string $sign)
 * @method static string sm2Encrypt(string $text)
 * @method static string sm2Decrypt(string $cipherText)
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
        return SmCryptorManager::class;
    }
}
