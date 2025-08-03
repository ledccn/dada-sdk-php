<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 订单取消原因来源
 */
class OrderCancelFromEnums extends EnumsInterface
{
    /**
     * 默认
     */
    public const DEFAULT = 0;
    /**
     * 达达配送员取消
     */
    public const COURIER = 1;
    /**
     * 商家取消
     */
    public const BUSINESS = 2;
    /**
     * 系统或客服取消
     */
    public const SYSTEM = 3;

    /**
     * 枚举说明列表
     * @return string[]
     */
    public static function cases(): array
    {
        return [
            self::DEFAULT => '默认',
            self::COURIER => '达达配送员取消',
            self::BUSINESS => '商家主动取消',
            self::SYSTEM => '系统或客服取消',
        ];
    }
}
