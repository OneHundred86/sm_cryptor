<?php


namespace Oh86\SmCryptor\Impl;


use Oh86\Sm\Sm4;
use Oh86\SmCryptor\Cryptor;

class LocalCryptor implements Cryptor
{
    private string $sm4Key;
    private string $hmacKey;

    private Sm4 $sm4Cryptor;

    public function __construct(array $config)
    {
        $this->sm4Key = $config["sm4_key"];
        $this->hmacKey = base64_decode($config["hmac_key"]);

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
     * @throws \Oh86\Sm\Exceptions\SM4KeyException
     * @throws \Oh86\Sm\Exceptions\SM4EncryptException
     */
    public function sm4Encrypt(string $text): string
    {
        return $this->sm4Cryptor->encrypt($text);
    }

    /**
     * @throws \Oh86\Sm\Exceptions\SM4KeyException
     * @throws \Oh86\Sm\Exceptions\SM4Exception
     */
    public function sm4Decrypt(string $cipherText): string
    {
        return $this->sm4Cryptor->decrypt($cipherText);
    }
}
