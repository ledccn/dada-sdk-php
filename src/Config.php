<?php

namespace Ledc\DaDa;

use JsonSerializable;

/**
 * 达达秒送配置类
 * @author david <367013672@qq.com>
 * @date 2025年7月31日
 * @link https://github.com/ledccn/dada-sdk-php
 * @license MIT
 * @document https://newopen.imdada.cn
 */
class Config implements JsonSerializable
{
    /**
     * 配置前缀
     */
    public const CONFIG_PREFIX = 'dada_';
    /**
     * 测试环境
     */
    public const BASE_URL_TEST = 'https://newopen.qa.imdada.cn';
    /**
     * 生产环境
     */
    public const BASE_URL_PROD = 'https://newopen.imdada.cn';
    /**
     * 应用信息：app_key 应用ID
     */
    protected string $appKey;
    /**
     * 应用信息：app_secret 应用密钥
     */
    protected string $appSecret;
    /**
     * 应用信息：source_id 商户编号
     */
    protected string $sourceId;
    /**
     * 应用信息：source_id 商户编号（测试环境）
     * @var string
     */
    protected string $sourceIdTest = '';
    /**
     * 应用信息：shop_no 门店编号（测试环境）
     */
    protected string $shopNoTest = '';
    /**
     * 是否调试模式
     * @var bool true:测试环境，false:生产环境
     */
    protected bool $debug = false;
    /**
     * 请求超时时间
     * @var int
     */
    protected int $timeout = 10;
    /**
     * 是否启用
     * @var bool
     */
    protected bool $enabled = false;

    /**
     * 构造函数
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * 获取应用ID AppKey
     * @return string
     */
    final public function getAppKey(): string
    {
        return $this->appKey;
    }

    /**
     * 获取应用密钥 AppSecret
     * @return string
     */
    final public function getAppSecret(): string
    {
        return $this->appSecret;
    }

    /**
     * 获取商户编号 SourceId
     * @return string
     */
    final public function getSourceId(): string
    {
        return $this->sourceId;
    }

    /**
     * 获取商户编号 SourceIdTest（测试环境）
     * @return string
     */
    final public function getSourceIdTest(): string
    {
        return $this->sourceIdTest;
    }

    /**
     * 获取门店编号 ShopNoTest（测试环境）
     * @return string
     */
    final public function getShopNoTest(): string
    {
        return $this->shopNoTest;
    }

    /**
     * 获取超时时间 Timeout
     * @return int
     */
    final public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * 是否调试模式
     * @return bool
     */
    final public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * 是否启用
     * @return bool
     */
    final public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * 设置是否调试模式
     * @param bool $debug
     * @return Config
     */
    final public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * 获取接口地址
     * @return string
     */
    final public function getBaseUrl(): string
    {
        return $this->isDebug() ? self::BASE_URL_TEST : self::BASE_URL_PROD;
    }

    /**
     * 获取商户编号
     * @return string
     */
    final public function autoGetSourceId(): string
    {
        return $this->isDebug() ? $this->getSourceIdTest() : $this->getSourceId();
    }

    /**
     * 生成参数的签名
     * @param array $params 所有参数
     * @param string $appSecret 应用密钥
     * @return string
     */
    final public static function generateSignature(array $params, string $appSecret): string
    {
        // 第一步：将参与签名的参数按照键值(key)进行字典排序
        ksort($params);
        // 第二步：将排序过后的参数，进行key和value字符串拼接
        $original = '';
        foreach ($params as $key => $value) {
            $original .= $key . $value;
        }
        // 第三步：将拼接后的字符串首尾加上app_secret秘钥，合成签名字符串
        $plaintext = $appSecret . $original . $appSecret;
        // 第四步：对签名字符串计算MD5，生成32位的字符串，转换为大写
        return strtoupper(md5($plaintext));
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * 转数组
     * @return array
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    /**
     * 转字符串
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * 转字符串
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
