##### 1.安装
```shell
composer install oh86/sm_cryptor
php artisan vendor:publish --provider='Oh86\SmCryptor\SmCryptorServiceProvider'
```

##### 2.配置env
```dotenv
# 本地密钥
SM4_KEY=4f17d993e1c602bc7cfa92377e223e6b    # hex，32位
HMAC_KEY=7725db43aa18e3702719f9c15702a7cf   # hex
# 电信密码池
TELECOM_ENCRYPTOR_HOST=https://36.140.66.11:9821
TELECOM_ENCRYPTOR_AK=
TELECOM_ENCRYPTOR_SK=
TELECOM_ENCRYPTOR_SM4_KEY_INDEX=1
TELECOM_ENCRYPTOR_HMAC_KEY_INDEX=1
# 国密驱动
SM_CRYPTOR_DRIVER=local
```

##### 3.使用示例
```php
use Oh86\SmCryptor\Facades\Cryptor;

>>> Cryptor::sm3("123")
=> "6e0f9e14344c5406a0cf5a3b4dfb665f87f4a771a31f7edbb5c72874a32b2957"
>>> Cryptor::hmacSm3("123")
=> "2d0c6f15f8ba4570f1f9688cb162ce874d883d08837c08c68f34eb8abfc40624"
>>> $en = sm4Encrypt("123")
>>> $en = Cryptor::sm4Encrypt("123")
=> "819b7dad97bc32f0f490a7e32efcf886"
>>> Cryptor::sm4Decrypt($en)
=> "123"
```
