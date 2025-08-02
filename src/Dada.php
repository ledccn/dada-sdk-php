<?php

namespace Ledc\DaDa;

use Ledc\DaDa\Clients\Account;
use Ledc\DaDa\Clients\Merchant;
use Ledc\DaDa\Clients\Order;

/**
 * 达达秒送
 * @author david <367013672@qq.com>
 * @date 2025年7月31日
 * @link https://github.com/ledccn/dada-sdk-php
 * @license MIT
 * @document https://newopen.imdada.cn
 */
class Dada
{
    /**
     * 客户端对象
     * @var Client
     */
    protected Client $client;
    /**
     * 缓存的客户端对象实例
     * @var array
     */
    protected array $instances = [];

    /**
     * 构造函数
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->client = new Client($config);
    }

    /**
     * 获取配置对象
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->client->getConfig();
    }

    /**
     * 客户端对象
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * 商户管理
     * @return Merchant
     */
    public function merchant(): Merchant
    {
        return $this->instances['merchant'] ?? ($this->instances['merchant'] = new Merchant($this->client));
    }

    /**
     * 订单管理
     * @return Order
     */
    public function order(): Order
    {
        return $this->instances['order'] ?? ($this->instances['order'] = new Order($this->client));
    }

    /**
     * 账户管理
     * @return Account
     */
    public function account(): Account
    {
        return $this->instances['account'] ?? ($this->instances['account'] = new Account($this->client));
    }
}