<?php

namespace Ledc\DaDa\Parameters;

use Ledc\SupportSdk\Parameters;

/**
 * 创建配送单后的相应参数
 */
class OrderResponse extends Parameters
{
    /**
     * 配送距离(单位：米)
     * @var float
     */
    public float $distance;
    /**
     * 实际运费(单位：元)，运费减去优惠券费用
     * @var float
     */
    public float $fee;
    /**
     * 运费(单位：元)
     * @var float
     */
    public float $deliverFee;
    /**
     * 优惠券费用(单位：元)
     * @var float
     */
    public float $couponFee = 0.0;
    /**
     * 小费（单位：元，精确小数点后一位，小费金额不能高于订单金额。）
     * @var float
     */
    public float $tips = 0.0;
    /**
     * 保价费(单位：元)
     * @var float
     */
    public float $insuranceFee = 0.0;
    /**
     * 达达秒送配送单号
     * @var string|null
     */
    public ?string $deliveryNo = null;
    /**
     * 配送单过期时间戳
     * @var int|null
     */
    public ?int $expiredTime = null;

    /**
     * 必填参数
     * @return string[]
     */
    protected function getRequiredKeys(): array
    {
        return ['distance', 'fee', 'deliverFee', 'couponFee', 'tips', 'insuranceFee'];
    }
}
