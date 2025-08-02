<?php

namespace Ledc\DaDa;

use Ledc\DaDa\Clients\Merchant;
use Ledc\SupportSdk\HttpResponse;
use Ledc\SupportSdk\Utils;
use RuntimeException;

/**
 * 达达秒送客户端
 * @author david <367013672@qq.com>
 * @date 2025年7月31日
 * @link https://github.com/ledccn/dada-sdk-php
 * @license MIT
 * @document https://newopen.imdada.cn
 */
class Client
{
    /**
     * JSON 编码参数
     */
    public const JSON_ENCODE_FLAGS = JSON_UNESCAPED_UNICODE;
    /**
     * 达达配置
     * @var Config
     */
    private Config $config;

    /**
     * 构造函数
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * 获取配置
     * @return Config
     */
    final public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * 获取系统参数
     * @param string $uri
     * @return array
     */
    protected function systemParams(string $uri): array
    {
        $timestamp = time();
        if ($uri === Merchant::REGISTER) {
            $source_id = '';
        } else {
            $source_id = $this->getConfig()->autoGetSourceId();
        }
        return [
            'app_key' => $this->getConfig()->getAppKey(),
            'timestamp' => $timestamp,
            'format' => 'json',
            'v' => '1.0',
            'source_id' => $source_id,
        ];
    }

    /**
     * GET请求
     * @param string $uri 请求接口名
     * @param array $data 所有请求参数
     * @param string $encoding 压缩方式
     * @return array
     */
    public function get(string $uri, array $data = [], string $encoding = 'gzip,deflate'): array
    {
        $baseUrl = $this->getConfig()->getBaseUrl();
        $ch = curl_init();
        if (!empty($data)) {
            $uri .= '?' . http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $uri);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_ENCODING, $encoding);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if (parse_url($baseUrl, PHP_URL_SCHEME) === 'https') {
            //false 禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //0 时不检查名称（SSL 对等证书中的公用名称字段或主题备用名称（Subject Alternate Name，简称 SNA）字段是否与提供的主机名匹配）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->getConfig()->getTimeout());
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->getConfig()->getTimeout());
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    // 自动跳转，跟随请求Location
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);         // 递归次数

        $httpResponse = new HttpResponse(
            curl_exec($ch),
            (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE),
            curl_errno($ch),
            curl_error($ch)
        );
        curl_close($ch);

        return $this->parseHttpResponse($httpResponse);
    }

    /**
     * 发起POST请求
     * @param string $uri 请求接口名
     * @param array $data 业务参数
     * @param array $with 附加的透传参数
     * @param bool $withSignature 是否需要签名
     * @return array
     */
    final public function post(string $uri, array $data = [], array $with = [], bool $withSignature = true): array
    {
        // 过滤空值
        $data = Utils::filter($data);
        // body内参数见各接口文档说明，当没有业务参数的时候，body需要赋值为空字符串，即body:""。
        $body = empty($data) ? '' : json_encode($data, self::JSON_ENCODE_FLAGS);
        // 合并请求参数：系统参数、附加的透传参数、接口业务参数
        $params = array_merge($this->systemParams($uri), $with, ['body' => $body]);
        // 发送请求并解析响应，返回结果
        $httpResponse = $this->request($uri, $params, $withSignature);
        return $this->parseHttpResponse($httpResponse);
    }

    /**
     * 发起HTTP请求
     * @param string $uri 请求接口名
     * @param array $params 所有请求参数
     * @param bool $withSignature 是否需要签名
     * @return HttpResponse
     */
    final public function request(string $uri, array $params, bool $withSignature = true): HttpResponse
    {
        $baseUrl = $this->getConfig()->getBaseUrl();
        if ($withSignature) {
            unset($params['signature']);
            // 签名请求参数
            $signature = Config::generateSignature($params, $this->getConfig()->getAppSecret());
            $params['signature'] = $signature;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8']);
        if (parse_url($baseUrl, PHP_URL_SCHEME) === 'https') {
            //false 禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //0 时不检查名称（SSL 对等证书中的公用名称字段或主题备用名称（Subject Alternate Name，简称 SNA）字段是否与提供的主机名匹配）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params, self::JSON_ENCODE_FLAGS));
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->getConfig()->getTimeout());
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->getConfig()->getTimeout());
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    // 自动跳转，跟随请求Location
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);         // 递归次数
        $response = curl_exec($ch);

        $result = new HttpResponse(
            $response,
            (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE),
            curl_errno($ch),
            curl_error($ch)
        );
        curl_close($ch);

        return $result;
    }

    /**
     * 解析HTTP响应
     * @param HttpResponse $httpResponse
     * @return array
     */
    final public function parseHttpResponse(HttpResponse $httpResponse): array
    {
        if ($httpResponse->isFailed()) {
            throw new RuntimeException('CURL请求Dada接口失败：' . $httpResponse->toJson(JSON_UNESCAPED_UNICODE));
        }

        $response = json_decode($httpResponse->getResponse(), true);
        $code = $response['code'] ?? -1;
        $status = $response['status'] ?? '';
        $msg = $response['msg'] ?? '';
        if (0 === $code && 'success' === $status) {
            $result = $response['result'] ?? [];
            return [$result, $msg];
        }

        $message = (string)($msg ?: $httpResponse->getResponse());
        throw new RuntimeException('Dada接口返回错误：' . $message);
    }
}
