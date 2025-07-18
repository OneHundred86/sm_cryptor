<?php

namespace Oh86\SmCryptor;

/**
 * 密码机接口
 */
interface Cryptor
{
    /**
     * 计算SM3摘要
     * @param string $text
     * @return string
     */
    public function sm3(string $text): string;

    /**
     * 计算SM3-HMAC摘要
     * @param string $text
     * @return string
     */
    public function hmacSm3(string $text): string;

    /**
     * SM4加密
     * @param string $text
     * @return string
     */
    public function sm4Encrypt(string $text): string;

    /**
     * SM4解密
     * @param string $cipherText
     * @return string
     */
    public function sm4Decrypt(string $cipherText): string;

    /**
     * SM2生成签名
     * @param string $text
     * @return string
     */
    public function sm2GenSign(string $text): string;

    /**
     * SM2验证签名
     * @param string $text
     * @param string $sign
     * @return bool
     */
    public function sm2VerifySign(string $text, string $sign): bool;

    /**
     * SM2加密
     * @param string $text
     * @return string
     */
    public function sm2Encrypt(string $text): string;

    /**
     * SM2解密
     * @param string $cipherText
     * @return string
     */
    public function sm2Decrypt(string $cipherText): string;

    /**
     * UKey导入证书，获取证书id
     * @param string $certificate
     * @param string $ukeyName
     * @return string
     */
    public function ukeyImportCert(string $certificate, string $ukeyName): string;

    /**
     * UKey验证签名
     * @param string $certificateId
     * @param string $text
     * @param string $sign
     * @return bool
     */
    public function ukeyVerifySign(string $certificateId, string $text, string $sign): bool;
}
