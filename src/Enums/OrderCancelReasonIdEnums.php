<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 订单取消原因ID枚举
 */
class OrderCancelReasonIdEnums extends EnumsInterface
{
    /**
     * 没有配送员接单
     */
    public const NO_DELIVERY_MAN_ACCEPTED = 1;
    /**
     * 配送员没来取货
     */
    public const DELIVERY_MAN_DID_NOT_PICK_UP = 2;
    /**
     * 配送员态度太差
     */
    public const DELIVERY_MAN_ATTITUDE_TOO_BAD = 3;
    /**
     * 顾客取消订单
     */
    public const CUSTOMER_CANCELED_ORDER = 4;
    /**
     * 订单填写错误
     */
    public const ORDER_FILLING_ERROR = 5;
    /**
     * 配送员让我取消此单
     */
    public const DELIVERY_MAN_ASKED_ME_TO_CANCEL = 34;
    /**
     * 配送员不愿上门取货
     */
    public const DELIVERY_MAN_REFUSED_TO_PICK_UP = 35;
    /**
     * 我不需要配送了
     */
    public const NO_LONGER_NEED_DELIVERY = 36;
    /**
     * 配送员以各种理由表示无法完成订单
     */
    public const DELIVERY_MAN_GAVE_VARIOUS_REASONS = 37;
    /**
     * 其他
     */
    public const OTHER = 10000;

    /**
     * 枚举说明列表
     * @return string[]
     */
    public static function cases(): array
    {
        return [
            self::NO_DELIVERY_MAN_ACCEPTED => '没有配送员接单',
            self::DELIVERY_MAN_DID_NOT_PICK_UP => '配送员没来取货',
            self::DELIVERY_MAN_ATTITUDE_TOO_BAD => '配送员态度太差',
            self::CUSTOMER_CANCELED_ORDER => '顾客取消订单',
            self::ORDER_FILLING_ERROR => '订单填写错误',
            self::DELIVERY_MAN_ASKED_ME_TO_CANCEL => '配送员让我取消此单',
            self::DELIVERY_MAN_REFUSED_TO_PICK_UP => '配送员不愿上门取货',
            self::NO_LONGER_NEED_DELIVERY => '我不需要配送了',
            self::DELIVERY_MAN_GAVE_VARIOUS_REASONS => '配送员以各种理由表示无法完成订单',
            self::OTHER => '其他',
        ];
    }
}
