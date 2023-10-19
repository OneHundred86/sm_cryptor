<?php


namespace Oh86\SmCryptor\Impl;


use Oh86\Sm\Exceptions\Exception;
use Oh86\Sm\Sm4;
use Oh86\SmCryptor\Cryptor;
use Oh86\SmCryptor\Exceptions\SmCryptorException;

class LocalCryptor implements Cryptor
{
    private string $sm4Key;
    private string $hmacKey;

    private Sm4 $sm4Cryptor;

    public function __construct(array $config)
    {
        $this->sm4Key = $config["sm4_key"];
        $this->hmacKey = hex2bin($config["hmac_key"]);

        $this->sm4Cryptor = new Sm4($this->sm4Key);
    }

    public function sm3(string $text): string
    {
        return sm3($text, false);
    }

    public function hmacSm3(string $text): string
    {
        return hmac_sm3($text, $this->hmacKey);
    }

    /**
     * @throws SmCryptorException
     */
    public function sm4Encrypt(string $text): string
    {
        try {
            return $this->sm4Cryptor->encrypt($text);
        } catch (Exception $e) {
            throw new SmCryptorException($e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     */
    public function sm4Decrypt(string $cipherText): string
    {
        try {
            return $this->sm4Cryptor->decrypt($cipherText);
        } catch (Exception $e) {
            throw new SmCryptorException($e->getMessage());
        }
    }
}
