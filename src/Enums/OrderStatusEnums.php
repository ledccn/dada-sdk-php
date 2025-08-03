<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 订单状态枚举
 */
class OrderStatusEnums extends EnumsInterface
{
    /**
     * 待接单
     */
    public const PENDING_ACCEPT = 1;
    /**
     * 待取货
     */
    public const PENDING_PICKUP = 2;
    /**
     * 骑士到店
     */
    public const RIDER_ARRIVED = 100;
    /**
     * 配送中
     */
    public const IN_DELIVERY = 3;
    /**
     * 已完成
     */
    public const COMPLETED = 4;
    /**
     * 已取消
     */
    public const CANCELLED = 5;
    /**
     * 已追加待接单
     */
    public const ADDITIONAL_PENDING_ACCEPT = 8;
    /**
     * 妥投异常之物品返回中
     */
    public const RETURNING_FOR_DELIVERY_EXCEPTION = 9;
    /**
     * 妥投异常之物品返回完成
     */
    public const RETURNED_FOR_DELIVERY_EXCEPTION = 10;
    /**
     * 售后取件单送达门店
     */
    public const AFTER_SALES_PICKUP_DELIVERED = 6;
    /**
     * 创建达达运单失败
     */
    public const CREATE_ORDER_FAILED = 1000;

    /**
     * 获取所有订单状态
     * @return array
     */
    public static function cases(): array
    {
        return [
            self::PENDING_ACCEPT => '待接单',
            self::PENDING_PICKUP => '待取货',
            self::RIDER_ARRIVED => '骑士到店',
            self::IN_DELIVERY => '配送中',
            self::COMPLETED => '已完成',
            self::CANCELLED => '已取消',
            self::ADDITIONAL_PENDING_ACCEPT => '已追加待接单',
            self::RETURNING_FOR_DELIVERY_EXCEPTION => '妥投异常之物品返回中',
            self::RETURNED_FOR_DELIVERY_EXCEPTION => '妥投异常之物品返回完成',
            self::AFTER_SALES_PICKUP_DELIVERED => '售后取件单送达门店',
            self::CREATE_ORDER_FAILED => '创建达达运单失败',
        ];
    }
}
