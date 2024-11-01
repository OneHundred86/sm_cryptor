<?php

namespace Oh86\SmCryptor;

use Oh86\SmCryptor\Exceptions\NotImpletmentException;

abstract class AbstractCryptor implements Cryptor
{

    public function sm3(string $text): string
    {
        throw new NotImpletmentException("sm3算法未实现");
    }

    public function hmacSm3(string $text): string
    {
        throw new NotImpletmentException("hmacSm3算法未实现");
    }

    public function sm4Encrypt(string $text): string
    {
        throw new NotImpletmentException("sm4Encrypt算法未实现");
    }

    public function sm4Decrypt(string $cipherText): string
    {
        throw new NotImpletmentException("sm4Decrypt算法未实现");
    }

    public function sm2GenSign(string $text): string
    {
        throw new NotImpletmentException("sm2GenSign算法未实现");
    }

    public function sm2VerifySign(string $text, string $sign): bool
    {
        throw new NotImpletmentException("sm2VerifySign算法未实现");
    }

    public function sm2Encrypt(string $text): string
    {
        throw new NotImpletmentException("sm2Encrypt算法未实现");
    }

    public function sm2Decrypt(string $cipherText): string
    {
        throw new NotImpletmentException("sm2Decrypt算法未实现");
    }
}
