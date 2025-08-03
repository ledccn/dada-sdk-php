<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 商家投诉达达，投诉原因ID枚举类
 */
class OrderComplaintDadaEnums extends EnumsInterface
{
    /**
     * 达达态度恶劣
     */
    public const ATTITUDE_AWFUL = 1;
    /**
     * 接单后未取货
     */
    public const NOT_PICK_UP = 2;
    /**
     * 取货速度太慢
     */
    public const PICK_UP_TOO_SLOW = 3;
    /**
     * 送货速度太慢
     */
    public const DELIVERY_TOO_SLOW = 4;
    /**
     * 货品未送达
     */
    public const NOT_DELIVERED = 5;
    /**
     * 货品损坏
     */
    public const GOODS_DAMAGED = 6;
    /**
     * 违规收取顾客小费
     */
    public const ILLEGAL_TIP_CHARGE = 7;
    /**
     * 达达衣冠不整
     */
    public const UNKEMPT_APPEARANCE = 11;
    /**
     * 达达恶意取消订单
     */
    public const MALICIOUS_CANCEL_ORDER = 69;
    /**
     * 达达提前点击取货/送达
     */
    public const PREMATURE_CLICK_PICK_UP_OR_DELIVER = 71;
    /**
     * 达达无标准保温箱
     */
    public const NO_STANDARD_INSULATION_BOX = 214;
    /**
     * 无法联系上骑士
     */
    public const CANNOT_CONTACT_RIDER = 251;
    /**
     * 没有冰袋
     */
    public const NO_ICE_BAG = 40002;
    /**
     * 虚假发起妥投失败
     */
    public const FALSE_DELIVERY_FAILURE = 40004;
    /**
     * 骑士肇事逃逸
     */
    public const RIDER_HIT_AND_RUN = 50209;
    /**
     * 骑士偷窃物品
     */
    public const RIDER_STEALING = 50210;
    /**
     * 骑士拒绝取货/配送
     */
    public const RIDER_REFUSE_PICK_UP_OR_DELIVERY = 50244;
    /**
     * 骑士私自取消订单
     */
    public const RIDER_PRIVATE_CANCEL_ORDER = 50245;
    /**
     * 骑士骚扰/殴打
     */
    public const RIDER_HARASSMENT_OR_ASSAULT = 50246;

    /**
     * 获取所有投诉原因
     * @return array
     */
    public static function cases(): array
    {
        return [
            self::ATTITUDE_AWFUL => '达达态度恶劣',
            self::NOT_PICK_UP => '接单后未取货',
            self::PICK_UP_TOO_SLOW => '取货速度太慢',
            self::DELIVERY_TOO_SLOW => '送货速度太慢',
            self::NOT_DELIVERED => '货品未送达',
            self::GOODS_DAMAGED => '货品损坏',
            self::ILLEGAL_TIP_CHARGE => '违规收取顾客小费',
            self::UNKEMPT_APPEARANCE => '达达衣冠不整',
            self::MALICIOUS_CANCEL_ORDER => '达达恶意取消订单',
            self::PREMATURE_CLICK_PICK_UP_OR_DELIVER => '达达提前点击取货/送达',
            self::NO_STANDARD_INSULATION_BOX => '达达无标准保温箱',
            self::CANNOT_CONTACT_RIDER => '无法联系上骑士',
            self::NO_ICE_BAG => '没有冰袋',
            self::FALSE_DELIVERY_FAILURE => '虚假发起妥投失败',
            self::RIDER_HIT_AND_RUN => '骑士肇事逃逸',
            self::RIDER_STEALING => '骑士偷窃物品',
            self::RIDER_REFUSE_PICK_UP_OR_DELIVERY => '骑士拒绝取货/配送',
            self::RIDER_PRIVATE_CANCEL_ORDER => '骑士私自取消订单',
            self::RIDER_HARASSMENT_OR_ASSAULT => '骑士骚扰/殴打',
        ];
    }
}
