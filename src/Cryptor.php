<?php


namespace Oh86\SmCryptor;


interface Cryptor
{
    public function sm3(string $text): string;
    public function hmacSm3(string $text): string;
    public function sm4Encrypt(string $text): string;
    public function sm4Decrypt(string $cipherText): string;
}
