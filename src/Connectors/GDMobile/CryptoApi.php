<?php

namespace Oh86\SmCryptor\Connectors\GDMobile;

use GuzzleHttp\Client;
use Oh86\SmCryptor\Exceptions\HttpRequestException;

/**
 * 加密和解密服务接口
 */
class CryptoApi
{
    private string $host;
    private string $appId;
    private string $authToken;

    private Client $client;


    /** @param array{host: string, app_id: string, auth_token: string} $config */
    public function __construct(array $config)
    {
        $this->host = $config["host"];
        $this->appId = $config["app_id"];
        $this->authToken = $config["auth_token"];

        $this->setHttpClient(new Client());
    }

    public function setHttpClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $inData        base64编码
     * @param int $algId
     * @param string|null $publicKey
     * @param string|null $userId   用户ID，用于计算hashz，缺省按b'1234567812345678'处理
     * @return string               base64编码
     * @throws HttpRequestException
     */
    public function sm3(string $inData, int $algId = Constant::ALGID_SGD_SM3, ?string $publicKey = null, ?string $userId = null): string
    {
        $url = "{$this->host}/digest";
        $headers = [
            'appId' => $this->appId,
            'authToken' => $this->authToken,
        ];
        $params = [
            'algId' => $algId,
            'inData' => $inData,
            'publicKey' => $publicKey,
            'userId' => $userId,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        if ($result["code"] ?? null !== 0) {
            throw new HttpRequestException($response->getStatusCode(), $content, $url, $params, $headers);
        }

        return $result["data"]["digest"];
    }

    /**
     * @param string $plainData     base64编码
     * @param int $keyIndex
     * @param int $algId
     * @param string|null $iv       base64编码
     * @return string               base64编码
     * @throws HttpRequestException
     */
    public function sm4Encrypt(string $plainData, int $keyIndex, int $algId = Constant::ALGID_SGD_SM4_ECB, ?string $iv = null): string
    {
        $url = "{$this->host}/sym/encrypt";
        $headers = [
            'appId' => $this->appId,
            'authToken' => $this->authToken,
        ];
        $params = [
            'keyIndex' => $keyIndex,
            'algId' => $algId,
            'plainData' => $plainData,
            'iv' => $iv,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        if ($result["code"] ?? null !== 0) {
            throw new HttpRequestException($response->getStatusCode(), $content, $url, $params, $headers);
        }

        return $result["data"]["cipherData"];
    }

    /**
     * @param string $cipherData     base64编码
     * @param int $keyIndex
     * @param int $algId
     * @param string|null $iv       base64编码
     * @return string               base64编码
     * @throws HttpRequestException
     */
    public function sm4Decrypt(string $cipherData, int $keyIndex, int $algId = Constant::ALGID_SGD_SM4_ECB, ?string $iv = null): string
    {
        $url = "{$this->host}/sym/decrypt";
        $headers = [
            'appId' => $this->appId,
            'authToken' => $this->authToken,
        ];
        $params = [
            'keyIndex' => $keyIndex,
            'algId' => $algId,
            'cipherData' => $cipherData,
            'iv' => $iv,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        if ($result["code"] ?? null !== 0) {
            throw new HttpRequestException($response->getStatusCode(), $content, $url, $params, $headers);
        }

        return $result["data"]["plainData"];
    }

    /**
     * @param string $plainData         base64编码
     * @param int $keyIndex
     * @param string|null $publicKey    base64编码
     * @param int $algId
     * @return string                   base64编码，密文结构为C1C3C2，长度最大为192字节
     */
    public function sm2Encrypt(string $plainData, int $keyIndex, ?string $publicKey = null, int $algId = Constant::ALGID_SGD_SM2_3): string
    {
        $url = "{$this->host}/asym/encrypt";
        $headers = [
            'appId' => $this->appId,
            'authToken' => $this->authToken,
        ];
        $params = [
            'keyIndex' => $keyIndex,
            'algId' => $algId,
            'plainData' => $plainData,
            'publicKey' => $publicKey,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        if ($result["code"] ?? null !== 0) {
            throw new HttpRequestException($response->getStatusCode(), $content, $url, $params, $headers);
        }

        return $result["data"]["cipherData"];
    }

    /**
     * @param string $cipherData         base64编码，密文结构为C1C3C2，长度最大为192字节
     * @param int $keyIndex
     * @param int $algId
     * @return string                   base64编码
     */
    public function sm2Decrypt(string $cipherData, int $keyIndex, int $algId = Constant::ALGID_SGD_SM2_3): string
    {
        $url = "{$this->host}/asym/decrypt";
        $headers = [
            'appId' => $this->appId,
            'authToken' => $this->authToken,
        ];
        $params = [
            'keyIndex' => $keyIndex,
            'algId' => $algId,
            'cipherData' => $cipherData,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        if ($result["code"] ?? null !== 0) {
            throw new HttpRequestException($response->getStatusCode(), $content, $url, $params, $headers);
        }

        return $result["data"]["plainData"];
    }
}
