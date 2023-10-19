<?php


namespace Oh86\SmCryptor\Impl;


use GuzzleHttp\Exception\GuzzleException;
use Oh86\SmCryptor\Cryptor;
use Oh86\SmCryptor\Exceptions\SmCryptorException;
use Oh86\TelecomCryptor\Exceptions\DecryptException;
use Oh86\TelecomCryptor\Exceptions\EncryptException;
use Oh86\TelecomCryptor\Exceptions\FetchTokenException;
use Oh86\TelecomCryptor\Exceptions\HMACException;

class TelecomCryptor implements Cryptor
{
    private \Oh86\TelecomCryptor\Cryptor $cryptor;

    /**
     * @param array{host: string, ak: string, sk: string, eds_node: string, svs_node: string, sm4_key_index: int, hmac_key_index: int} $config
     */
    public function __construct(array $config)
    {
        $this->cryptor = new \Oh86\TelecomCryptor\Cryptor($config);
    }

    public function sm3(string $text): string
    {
        return sm3($text, false);
    }

    /**
     * @throws SmCryptorException
     * @throws GuzzleException
     */
    public function hmacSm3(string $text): string
    {
        try {
            return $this->cryptor->hmac($text, "SGD_SM3_HMAC");
        } catch (FetchTokenException $e) {
            throw new SmCryptorException($e->getMessage());
        } catch (HMACException $e) {
            throw new SmCryptorException($e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     * @throws GuzzleException
     */
    public function sm4Encrypt(string $text): string
    {
        try {
            return $this->cryptor->sm4Encrypt($text);
        } catch (EncryptException $e) {
            throw new SmCryptorException($e->getMessage());
        } catch (FetchTokenException $e) {
            throw new SmCryptorException($e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     * @throws GuzzleException
     */
    public function sm4Decrypt(string $cipherText): string
    {
        try {
            return $this->cryptor->sm4Decrypt($cipherText);
        } catch (DecryptException $e) {
            throw new SmCryptorException($e->getMessage());
        } catch (FetchTokenException $e) {
            throw new SmCryptorException($e->getMessage());
        }
    }
}
