<?php


namespace Oh86\SmCryptor\Impl;


use Oh86\Sm\Exceptions\Exception;
use Oh86\Sm\Sm2;
use Oh86\Sm\Sm4;
use Oh86\SmCryptor\AbstractCryptor;
use Oh86\SmCryptor\Exceptions\SmCryptorException;


class LocalCryptor extends AbstractCryptor
{
    private string $sm4Key;
    private string $hmacKey;
    private string $sm2PrivateKey;
    private string $sm2PublicKey;

    private Sm4 $sm4Cryptor;

    public function __construct(array $config)
    {
        $this->sm4Key = $config["sm4_key"];
        $this->hmacKey = hex2bin($config["hmac_key"]);
        $this->sm2PrivateKey = $config["sm2_private_key"];
        $this->sm2PublicKey = $config["sm2_public_key"];

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

    public function sm2GenSign(string $text): string
    {
        $hash = $this->sm3($text);

        $sm2 = new Sm2('hex', false);
        return $sm2->doSign($hash, $this->sm2PrivateKey);
    }

    public function sm2VerifySign(string $text, string $sign): bool
    {
        $hash = $this->sm3($text);
        $sm2 = new Sm2('hex', false);
        try {
            return $sm2->verifySign($hash, $sign, $this->sm2PublicKey);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function sm2Encrypt(string $text): string
    {
        if ($text == "") {
            return "";
        }

        $sm2 = new Sm2('hex', false);
        return $sm2->doEncrypt($text, $this->sm2PublicKey);
    }

    public function sm2Decrypt(string $cipherText): string
    {
        if ($cipherText == "") {
            return "";
        }

        $sm2 = new Sm2('hex', false);
        $text = $sm2->doDecrypt($cipherText, $this->sm2PrivateKey);

        if ($text == "") {
            throw new SmCryptorException("SM2解密失败");
        }

        return $text;
    }
}
