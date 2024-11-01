##### 1.安装
```shell
composer install oh86/sm_cryptor
php artisan vendor:publish --provider='Oh86\SmCryptor\SmCryptorServiceProvider'
```

##### 2.配置env
```dotenv
# 国密驱动
SM_CRYPTOR_DRIVER=local
# 本地密钥
SM4_KEY=4f17d993e1c602bc7cfa92377e223e6b
HMAC_KEY=7725db43aa18e3702719f9c15702a7cf
SM2_PUBLIC_KEY=04145c4a725692115e45e6c147bebc4e25ec024569b6e8589d2bcc9181a1cfe401747d8593d7f8fad8ba45635ea6a7c514555bd3298ccdae8e2391ae782b00d09d
SM2_PRIVATE_KEY=afbee3c2367df945294f39f23fac1678b4e7b4bc18b69a33890ae21bc6e43830

# 电信密码池
TELECOM_ENCRYPTOR_HOST=https://36.140.66.11:9821
TELECOM_EDS_NODE=
TELECOM_SVS_NODE=
TELECOM_ENCRYPTOR_AK=
TELECOM_ENCRYPTOR_SK=
TELECOM_ENCRYPTOR_SM4_KEY_INDEX=1
TELECOM_ENCRYPTOR_HMAC_KEY_INDEX=1

# 联通密码池
UNICOM_ENCRYPTOR_HOST=http://10.10.32.82:8415
UNICOM_ENCRYPTOR_AK=
UNICOM_ENCRYPTOR_SK=
UNICOM_ENCRYPTOR_SM4_KEY_INDEX=xxxtSM4
# 先配置上面配置，然后执行命令生成配置后再配置：php artisan sm:gen_unicom_session_key
UNICOM_ENCRYPTOR_SESSION_KEY_ALGID=
UNICOM_ENCRYPTOR_SESSION_KEY_KEYID=
UNICOM_ENCRYPTOR_SESSION_KEY_ENCRYPTED_SESSIONKEY=
```

##### 3.使用示例
```php
use Oh86\SmCryptor\Facades\Cryptor;

>>> Cryptor::sm3("123")
=> "6e0f9e14344c5406a0cf5a3b4dfb665f87f4a771a31f7edbb5c72874a32b2957"
>>> Cryptor::hmacSm3("123")
=> "2d0c6f15f8ba4570f1f9688cb162ce874d883d08837c08c68f34eb8abfc40624"
>>> 
>>> $en = Cryptor::sm4Encrypt("123")
=> "819b7dad97bc32f0f490a7e32efcf886"
>>> Cryptor::sm4Decrypt($en)
=> "123"
```
