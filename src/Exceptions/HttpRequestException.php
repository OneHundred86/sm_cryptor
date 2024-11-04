<?php

namespace Oh86\SmCryptor\Exceptions;

class HttpRequestException extends \Exception
{
    /**
     * 响应状态码
     * @var int
     */
    protected $status;

    /**
     * 响应体
     * @var string
     */
    protected $response;

    /**
     * 请求路径
     * @var string
     */
    protected $url;

    /**
     * 请求参数
     * @var array
     */
    protected $params;

    /**
     * 请求头
     * @var array
     */
    protected $headers;


    /**
     * @param int $status   响应状态码
     * @param string $response     响应体
     * @param string $url      请求url
     * @param array $params   请求参数
     * @param array $headers  请求头
     */
    public function __construct($status, $response, $url, $params = null, $headers = null)
    {
        $this->status = $status;
        $this->response = $response;
        $this->url = $url;
        $this->params = $params;
        $this->headers = $headers;
        parent::__construct("请求错误：" . $response, $status);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array|null
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return [
            "status" => $this->status,
            "response" => $this->response,
            "url" => $this->url,
            "params" => $this->params,
            "headers" => $this->headers,
        ];
    }
}
