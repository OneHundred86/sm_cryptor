<?php

namespace Oh86\SmCryptor\Connectors\GDMobile;

use GuzzleHttp\Client;
use Oh86\SmCryptor\Exceptions\HttpRequestException;

/**
 * 完整性服务接口
 */
class IntegrityApi
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
     * @param int $keyIndex
     * @return string               base64编码
     * @throws HttpRequestException
     */
    public function hmacSm3(string $inData, int $keyIndex): string
    {
        $url = "{$this->host}/hmac";
        $headers = [
            'appId' => $this->appId,
            'authToken' => $this->authToken,
        ];
        $params = [
            'keyIndex' => $keyIndex,
            'inData' => $inData,
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        if ($result['code'] ?? null !== 0) {
            throw new HttpRequestException($response->getStatusCode(), $content, $url, $params, $headers);
        }

        return $result['data']['hmac'];
    }
}
