<?php

namespace Oh86\SmCryptor\Impl;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Oh86\SmCryptor\Cryptor;
use Oh86\SmCryptor\Exceptions\SmCryptorException;
use Oh86\UnicomCryptor\Exceptions\CryptorException;
use Oh86\UnicomCryptor\V1\ClientV1;

class UnicomCryptor implements Cryptor
{
    private ClientV1 $clientV1;
    private string $sm4KeyIndex;
    /**
     * @var array{algID: int, keyID: string, encryptedSessionKey: string}
     */
    private array $sessionKeyContext;

    /**
     * @param array{host: string, access_key: string, secret_key: string, sm4_key_index: string, session_key_context: array} $config
     */
    public function __construct(array $config)
    {
        $this->sm4KeyIndex = Arr::pull($config, "sm4_key_index");
        $this->sessionKeyContext = Arr::pull($config, "session_key_context");
        $this->clientV1 = new ClientV1($config);
    }

    /**
     * @return array{algID: int, keyID: string, encryptedSessionKey: string}
     */
    protected function getSessionKeyContext(): array
    {
        return $this->sessionKeyContext;
    }

    /**
     * @throws SmCryptorException
     */
    public function genSessionKeyContext(): array
    {
        try {
            return $this->clientV1->generateKeyWithKek($this->sm4KeyIndex);
        } catch (CryptorException $e) {
            throw $this->toSmCryptorException($e);
        }
    }

    public function sm3(string $text): string
    {
        return sm3($text, false);
    }

    /**
     * @param string $text
     * @return string
     * @throws SmCryptorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hmacSm3(string $text): string
    {
        try {
            $outData = $this->clientV1->hmac(base64_encode($text), $this->getSessionKeyContext());
        } catch (CryptorException $e) {
            throw $this->toSmCryptorException($e);
        }

        return bin2hex((base64_decode($outData)));
    }

    protected function toSmCryptorException(CryptorException $e): SmCryptorException
    {
        return new SmCryptorException($e->getMessage().":".$e->getResponseBody());
    }

    /**
     * @throws SmCryptorException
     */
    public function sm4Encrypt(string $text): string
    {
        try {
            $outData = $this->clientV1->encrypt(base64_encode($text), $this->getSessionKeyContext());
        } catch (CryptorException $e) {
            throw $this->toSmCryptorException($e);
        }

        return bin2hex((base64_decode($outData)));
    }

    /**
     * @throws SmCryptorException
     * @throws GuzzleException
     */
    public function sm4Decrypt(string $cipherText): string
    {
        $text = hex2bin($cipherText);
        try {
            $outData = $this->clientV1->decrypt(base64_encode($text), $this->getSessionKeyContext());
        } catch (CryptorException $e) {
            throw $this->toSmCryptorException($e);
        }

        return base64_decode($outData);
    }
}
