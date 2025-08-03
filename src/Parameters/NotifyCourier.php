<?php

namespace Ledc\DaDa\Parameters;

use Ledc\DaDa\Contracts\Callback;
use Ledc\SupportSdk\Parameters;

/**
 * 骑士申请取消订单通知
 */
class NotifyCourier extends Parameters implements Callback
{
    use HasMessageTypeBody;

    /**
     * 商家第三方订单号
     * @var string
     */
    protected string $orderId;
    /**
     * 达达配送订单号
     * @var string|null
     */
    protected ?string $dadaOrderId = null;
    /**
     * 骑士取消原因
     * @var string
     */
    protected string $cancelReason;

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
     * 商家第三方订单号
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * 达达订单号
     * @return string|null
     */
    public function getDadaOrderId(): ?string
    {
        return $this->dadaOrderId;
    }

    /**
     * 骑士取消原因
     * @return string
     */
    public function getCancelReason(): string
    {
        return $this->cancelReason;
    }

    /**
     * 获取必填字段
     * @return string[]
     */
    protected function getRequiredKeys(): array
    {
        return ['messageType', 'messageBody', 'orderId', 'cancelReason'];
    }
}
