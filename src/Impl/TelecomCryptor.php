<?php


namespace Oh86\SmCryptor\Impl;


use Oh86\SmCryptor\Cryptor;

class TelecomCryptor implements Cryptor
{
    private \Oh86\TelecomCryptor\Cryptor $cryptor;

    public function __construct(array $config) {
        $this->cryptor = new \Oh86\TelecomCryptor\Cryptor($config);
    }


    public function sm3(string $text): string
    {
        return sm3($text, false);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Oh86\TelecomCryptor\Exceptions\HMACException
     * @throws \Oh86\TelecomCryptor\Exceptions\FetchTokenException
     */
    public function hmacSm3(string $text): string
    {
        return $this->cryptor->hmac($text, "SGD_SM3_HMAC");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Oh86\TelecomCryptor\Exceptions\EncryptException
     * @throws \Oh86\TelecomCryptor\Exceptions\FetchTokenException
     */
    public function sm4Encrypt(string $text): string
    {
        return $this->cryptor->sm4Encrypt($text);
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Oh86\TelecomCryptor\Exceptions\FetchTokenException
     * @throws \Oh86\TelecomCryptor\Exceptions\DecryptException
     */
    public function sm4Decrypt(string $cipherText): string
    {
        return $this->cryptor->sm4Decrypt($cipherText);
    }
}
