<?php

return [
    // local / telecom / unicom
    "driver" => env("SM_CRYPTOR_DRIVER", "local"),

    // 本地加解密
    "local" => [
        "sm4_key" => env("SM4_KEY", "08c8e6db4907dc755a6097d0abd417c5"),
        "hmac_key" => env("HMAC_KEY", "08c8e6db4907dc755a6097d0abd417c5"),
        "sm2_public_key" => env("SM2_PUBLIC_KEY", "04145c4a725692115e45e6c147bebc4e25ec024569b6e8589d2bcc9181a1cfe401747d8593d7f8fad8ba45635ea6a7c514555bd3298ccdae8e2391ae782b00d09d"),
        "sm2_private_key" => env("SM2_PRIVATE_KEY", "afbee3c2367df945294f39f23fac1678b4e7b4bc18b69a33890ae21bc6e43830"),
    ],

    // 电信密码池加解密
    "telecom" => [
        "host" => env("TELECOM_ENCRYPTOR_HOST"),
        "ak" => env("TELECOM_ENCRYPTOR_AK"),
        "sk" => env("TELECOM_ENCRYPTOR_SK"),
        "eds_node" => env("TELECOM_EDS_NODE"),
        "svs_node" => env("TELECOM_SVS_NODE"),
        "sm4_key_index" => (int) env("TELECOM_ENCRYPTOR_SM4_KEY_INDEX"),
        "hmac_key_index" => (int) env("TELECOM_ENCRYPTOR_HMAC_KEY_INDEX"),
    ],

    // 联通密码池加解密
    "unicom" => [
        "host" => env("UNICOM_ENCRYPTOR_HOST"),
        "access_key" => env("UNICOM_ENCRYPTOR_AK"),
        "secret_key" => env("UNICOM_ENCRYPTOR_SK"),
        "sm4_key_index" => env("UNICOM_ENCRYPTOR_SM4_KEY_INDEX"),
        "session_key_context" => [
            "algID" => (int) env("UNICOM_ENCRYPTOR_SESSION_KEY_ALGID"),
            "keyID" => env("UNICOM_ENCRYPTOR_SESSION_KEY_KEYID"),
            "encryptedSessionKey" => env("UNICOM_ENCRYPTOR_SESSION_KEY_ENCRYPTED_SESSIONKEY"),
        ],
    ],

    // gd移动密码池
    "gdmobile" => [
        "crypto" => [
            "host" => env("GDMOBILE_CRYPTO_HOST"),
            "app_id" => env("GDMOBILE_CRYPTO_APP_ID"),
            "auth_token" => env("GDMOBILE_CRYPTO_AUTH_TOKEN"),
            "sm4_key_index" => (int) env("GDMOBILE_CRYPTO_SM4_KEY_INDEX"),
            "sm2_key_index" => (int) env("GDMOBILE_CRYPTO_SM2_KEY_INDEX"),
        ],
        "integrity" => [
            "host" => env("GDMOBILE_INTEGRITY_HOST"),
            "app_id" => env("GDMOBILE_INTEGRITY_APP_ID"),
            "auth_token" => env("GDMOBILE_INTEGRITY_AUTH_TOKEN"),
            "hmac_key_index" => (int) env("GDMOBILE_INTEGRITY_HMAC_KEY_INDEX"),
        ],
    ],
];
