<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 回调通知的消息类型枚举
 */
class NotifyMessageTypeEnums extends EnumsInterface
{
    /**
     * 骑士取消
     */
    public const COURIER_CANCEL = 1;
    /**
     * 门店审核（已废弃）
     */
    public const STORE_REVIEW = 2;
    /**
     * 异常上报
     */
    public const EXCEPTION_REPORT = 3;
    /**
     * 门店状态变更（新增）
     */
    public const STORE_STATUS_CHANGE = 4;

    /**
     * 获取所有回调消息类型
     * @return array
     */
    public static function cases(): array
    {
        return [
            self::COURIER_CANCEL => '骑士取消',
            self::STORE_REVIEW => '门店审核（已废弃）',
            self::EXCEPTION_REPORT => '异常上报',
            self::STORE_STATUS_CHANGE => '门店状态变更（新增）',
        ];
    }

    /**
     * 根据类型ID获取类型名称
     * @param int $type 类型ID
     * @return string|null
     */
    public static function getTypeName(int $type): ?string
    {
        $types = self::cases();
        return $types[$type] ?? null;
    }

    /**
     * 检查类型ID是否有效
     * @param int $type 类型ID
     * @return bool
     */
    public static function isValidType(int $type): bool
    {
        return array_key_exists($type, self::cases());
    }

    /**
     * 检查是否为已废弃的类型
     * @param int $type 类型ID
     * @return bool
     */
    public static function isDeprecatedType(int $type): bool
    {
        return $type === self::STORE_REVIEW;
    }
}
