<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 重复回传状态原因枚举类
 */
class OrderRepeatReasonTypeEnums extends EnumsInterface
{
    /**
     * 重新分配骑士
     */
    public const REASSIGN_RIDER = 1;

    /**
     * 骑士转单
     */
    public const RIDER_TRANSFER_ORDER = 2;

    /**
     * 获取所有重复回传状态原因
     * @return array
     */
    public static function cases(): array
    {
        return [
            self::REASSIGN_RIDER => '重新分配骑士',
            self::RIDER_TRANSFER_ORDER => '骑士转单',
        ];
    }
}
