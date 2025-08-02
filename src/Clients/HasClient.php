<?php

namespace Ledc\DaDa\Clients;

use Ledc\DaDa\Client;
use Ledc\DaDa\Config;

/**
 * 达达秒送客户端
 */
trait HasClient
{
    /**
     * 达达秒送客户端
     * @var Client
     */
    protected Client $client;

    /**
     * 构造函数
     * @param Client $client 达达秒送客户端
     */
    final public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取达达秒送客户端对象
     * @return Client
     */
    final public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * 获取达达秒送配置
     * @return Config
     */
    final public function getConfig(): Config
    {
        return $this->getClient()->getConfig();
    }

    /**
     * 发起POST请求并返回结果
     * @param string $uri 请求接口名
     * @param array $data 业务参数
     * @param array $with 附加的透传参数
     * @return array|int|string|bool
     */
    final public function post(string $uri, array $data = [], array $with = [])
    {
        return current($this->getClient()->post($uri, $data, $with));
    }
}
