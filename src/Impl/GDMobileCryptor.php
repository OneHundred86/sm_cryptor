<?php

namespace Oh86\SmCryptor\Impl;

use Illuminate\Support\Facades\Log;
use Oh86\SmCryptor\AbstractCryptor;
use Oh86\SmCryptor\Connectors\GDMobile\CryptoApi;
use Oh86\SmCryptor\Connectors\GDMobile\IntegrityApi;
use Oh86\SmCryptor\Exceptions\HttpRequestException;
use Oh86\SmCryptor\Exceptions\SmCryptorException;

class GDMobileCryptor extends AbstractCryptor
{
    /** @param array{host: string, app_id: string, auth_token: string, sm4_key_index: int}  */
    private array $cryptoConfig;

    /** @param array{host: string, app_id: string, auth_token: string, hmac_key_index: int} $integrityConfig */
    private array $integrityConfig;

    private CryptoApi $cryptoApi;
    private IntegrityApi $integrityApi;

    /** 
     * @param array{crypto: array{}, integrity: array{}} $config 
     */
    public function __construct(array $config)
    {
        $this->cryptoConfig = $config["crypto"];
        $this->integrityConfig = $config["integrity"];

        $this->cryptoApi = new CryptoApi($this->cryptoConfig);
        $this->integrityApi = new IntegrityApi($this->integrityConfig);
    }


    private function base64ToHex(string $base64): string
    {
        return bin2hex(base64_decode($base64));
    }

    private function hexToBase64(string $hex): string
    {
        return base64_encode(hex2bin($hex));
    }


    /**
     * @throws SmCryptorException
     */
    public function sm3(string $text): string
    {
        try {
            $base64 = $this->cryptoApi->sm3(base64_encode($text));
            return $this->base64ToHex($base64);
        } catch (HttpRequestException $e) {
            Log::error(__METHOD__, $e->getMessage());
            throw new SmCryptorException("SM3计算失败: " . $e->getMessage());
        }
    }

    public function hmacSm3(string $text): string
    {
        try {
            $base64 = $this->integrityApi->hmacSm3(base64_encode($text), $this->integrityConfig["hmac_key_index"]);
            return $this->base64ToHex($base64);
        } catch (HttpRequestException $e) {
            Log::error(__METHOD__, $e->getMessage());
            throw new SmCryptorException("HMAC-SM3计算失败: " . $e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     */
    public function sm4Encrypt(string $text): string
    {
        try {
            $base64 = $this->cryptoApi->sm4Encrypt(base64_encode($text), $this->cryptoConfig["sm4_key_index"]);
            return $this->base64ToHex($base64);
        } catch (HttpRequestException $e) {
            Log::error(__METHOD__, $e->getMessage());
            throw new SmCryptorException("SM4加密失败: " . $e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     */
    public function sm4Decrypt(string $cipherText): string
    {
        try {
            $base64 = $this->cryptoApi->sm4Decrypt($this->hexToBase64($cipherText), $this->cryptoConfig["sm4_key_index"]);
            return base64_decode($base64);
        } catch (HttpRequestException $e) {
            Log::error(__METHOD__, $e->getMessage());
            throw new SmCryptorException("SM4解密失败: " . $e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     */
    public function sm2Encrypt(string $text): string
    {
        try {
            $base64 = $this->cryptoApi->sm2Encrypt(base64_encode($text), $this->cryptoConfig["sm2_key_index"]);
            return $this->base64ToHex($base64);
        } catch (HttpRequestException $e) {
            Log::error(__METHOD__, $e->getMessage());
            throw new SmCryptorException("SM2加密失败: " . $e->getMessage());
        }
    }

    /**
     * @throws SmCryptorException
     */
    public function sm2Decrypt(string $cipherText): string
    {
        try {
            $base64 = $this->cryptoApi->sm2Decrypt($this->hexToBase64($cipherText), $this->cryptoConfig["sm2_key_index"]);
            return base64_decode($base64);
        } catch (HttpRequestException $e) {
            Log::error(__METHOD__, $e->getMessage());
            throw new SmCryptorException("SM2解密失败: " . $e->getMessage());
        }
    }
}
