<?php


namespace Oh86\SmCryptor;


use Oh86\SmCryptor\Impl\LocalCryptor;
use Oh86\SmCryptor\Impl\TelecomCryptor;

class Factory
{
    public static function createCryptor(string $type) :Cryptor
    {
        if ($type == "local"){
            return new LocalCryptor(config("sm_cryptor.local"));
        }elseif($type == "telecom") {
            return new TelecomCryptor(config("sm_cryptor.telecom"));
        }
    }
}
