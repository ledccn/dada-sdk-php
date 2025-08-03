<?php

namespace Ledc\DaDa\Parameters;

use Ledc\DaDa\Contracts\Callback;
use Ledc\SupportSdk\Parameters;

/**
 * 门店信息变更通知
 * - 部分门店信息发生变更场景会通过该接口通知，门店状态变更场景说明：
 * - 1.门店运力审核流程，如门店运力审核失败则门店自动下线，如审核通过则门店自动上线
 * - 2.运营操作门店上下线
 * - 回调地址URL请登录开发者账号，在【开发助手-应用信息】中进行配置。
 */
class NotifyShopUpdated extends Parameters implements Callback
{
    use HasMessageTypeBody;

    /**
     * 相应报文
     * - 如果回调返回失败(status='fail')或者请求超时，系统会重试3次。
     */
    public const RESPONSE = [
        // 门店信息变更通知：响应状态（ok或者fail）
        'status' => 'ok',
    ];
    /**
     * 门店编号
     * @var string
     */
    protected string $shopNo;
    /**
     * 门店名称
     * @var string
     */
    protected string $shopName;
    /**
     * 门店状态
     * - 1-已上线，0-已下线
     * @var int|null
     */
    protected ?int $shopStatus = null;
    /**
     * 门店状态描述
     * @var string
     */
    protected string $shopStatusDesc = '';
    /**
     * 门店运力审核状态
     * - 0-无需审核，1-审核通过，2-审核不通过，3-审核中
     * - 部分商户无需运力审核，该场景下该字段可能为空
     * @var int|null
     */
    protected ?int $approveStatus = null;
    /**
     * 运力审核状态描述
     * @var string
     */
    protected string $approveStatusDesc = '';
    /**
     * 变更时间（秒级时间戳），可能存在失败重试情况，请以最新时间的状态为准，避免影响下单
     * @var int
     */
    protected int $notifyTimeInSec;

    /**
     * 构造函数
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);
        $body = json_decode($this->getMessageBody(), true);
        $this->initProperties($body);
    }

    /**
     * @return string
     */
    public function getShopNo(): string
    {
        return $this->shopNo;
    }

    /**
     * @return string
     */
    public function getShopName(): string
    {
        return $this->shopName;
    }

    /**
     * @return int|null
     */
    public function getShopStatus(): ?int
    {
        return $this->shopStatus;
    }

    /**
     * @return string
     */
    public function getShopStatusDesc(): string
    {
        return $this->shopStatusDesc;
    }

    /**
     * @return int
     */
    public function getNotifyTimeInSec(): int
    {
        return $this->notifyTimeInSec;
    }

    /**
     * @return int|null
     */
    public function getApproveStatus(): ?int
    {
        return $this->approveStatus;
    }

    /**
     * @return string
     */
    public function getApproveStatusDesc(): string
    {
        return $this->approveStatusDesc;
    }

    /**
     * 获取必填字段
     * @return string[]
     */
    protected function getRequiredKeys(): array
    {
        return ['messageType', 'messageBody', 'shopNo', 'shopName', 'notifyTimeInSec'];
    }
}
