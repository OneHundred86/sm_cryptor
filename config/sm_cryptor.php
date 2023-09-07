<?php

return [
    // local / telecom
    "driver" => env("SM_CRYPTOR_DRIVER", "local"),

    // 本地加解密
    "local" => [
        "sm4_key" => env("SM4_KEY"),
        "hmac_key" => env("HMAC_KEY"),
    ],

    // 电信密码池加解密
    "telecom" => [
        "host" => env("TELECOM_ENCRYPTOR_HOST"),
        "ak" => env("TELECOM_ENCRYPTOR_AK"),
        "sk" => env("TELECOM_ENCRYPTOR_SK"),
        "sm4_key_index" => (int)env("TELECOM_ENCRYPTOR_SM4_KEY_INDEX"),
        "hmac_key_index" => (int)env("TELECOM_ENCRYPTOR_HMAC_KEY_INDEX"),
    ],
];
