<?php

namespace Ledc\DaDa\Enums;

use Ledc\SupportSdk\EnumsInterface;

/**
 * 商家类目枚举
 */
class MerchantCategoriesEnums extends EnumsInterface
{
    /**
     * 食品小吃
     */
    public const FOOD_SNACK = 1;

    /**
     * 饮料
     */
    public const BEVERAGE = 2;

    /**
     * 鲜花绿植
     */
    public const FLOWERS_PLANTS = 3;

    /**
     * 其他
     */
    public const OTHER = 5;

    /**
     * 文印票务
     */
    public const PRINTING_TICKETS = 8;

    /**
     * 便利店
     */
    public const CONVENIENCE_STORE = 9;

    /**
     * 水果生鲜
     */
    public const FRUITS_FRESH = 13;

    /**
     * 同城电商
     */
    public const LOCAL_ECOMMERCE = 19;

    /**
     * 医药
     */
    public const MEDICINE = 20;

    /**
     * 蛋糕
     */
    public const CAKE = 21;

    /**
     * 酒品
     */
    public const ALCOHOL = 24;

    /**
     * 小商品市场
     */
    public const SMALL_COMMODITY_MARKET = 25;

    /**
     * 服装
     */
    public const CLOTHING = 26;

    /**
     * 汽修零配
     */
    public const AUTO_REPAIR_PARTS = 27;

    /**
     * 数码家电
     */
    public const DIGITAL_APPLIANCES = 28;

    /**
     * 小龙虾/烧烤
     */
    public const LOBSTER_BBQ = 29;

    /**
     * 超市
     */
    public const SUPERMARKET = 31;

    /**
     * 火锅
     */
    public const HOT_POT = 51;

    /**
     * 个护美妆
     */
    public const BEAUTY_PERSONAL_CARE = 53;

    /**
     * 母婴
     */
    public const MATERNITY_BABY = 55;

    /**
     * 家居家纺
     */
    public const HOME_FURNISHING = 57;

    /**
     * 手机
     */
    public const MOBILE_PHONE = 59;

    /**
     * 家装
     */
    public const HOME_DECORATION = 61;

    /**
     * 成人用品
     */
    public const ADULT_PRODUCTS = 63;

    /**
     * 校园
     */
    public const CAMPUS = 65;

    /**
     * 高端市场
     */
    public const HIGH_END_MARKET = 66;

    /**
     * 枚举说明列表
     * @return string[]
     */
    public static function cases(): array
    {
        return self::getAllCategories();
    }

    /**
     * 获取所有商家类目
     * @return array
     */
    public static function getAllCategories(): array
    {
        return [
            self::FOOD_SNACK => '食品小吃',
            self::BEVERAGE => '饮料',
            self::FLOWERS_PLANTS => '鲜花绿植',
            self::OTHER => '其他',
            self::PRINTING_TICKETS => '文印票务',
            self::CONVENIENCE_STORE => '便利店',
            self::FRUITS_FRESH => '水果生鲜',
            self::LOCAL_ECOMMERCE => '同城电商',
            self::MEDICINE => '医药',
            self::CAKE => '蛋糕',
            self::ALCOHOL => '酒品',
            self::SMALL_COMMODITY_MARKET => '小商品市场',
            self::CLOTHING => '服装',
            self::AUTO_REPAIR_PARTS => '汽修零配',
            self::DIGITAL_APPLIANCES => '数码家电',
            self::LOBSTER_BBQ => '小龙虾/烧烤',
            self::SUPERMARKET => '超市',
            self::HOT_POT => '火锅',
            self::BEAUTY_PERSONAL_CARE => '个护美妆',
            self::MATERNITY_BABY => '母婴',
            self::HOME_FURNISHING => '家居家纺',
            self::MOBILE_PHONE => '手机',
            self::HOME_DECORATION => '家装',
            self::ADULT_PRODUCTS => '成人用品',
            self::CAMPUS => '校园',
            self::HIGH_END_MARKET => '高端市场',
        ];
    }

    /**
     * 根据品类ID获取品类名称
     * @param int $categoryId 品类ID
     * @return string|null
     */
    public static function getCategoryName(int $categoryId): ?string
    {
        $categories = self::getAllCategories();
        return $categories[$categoryId] ?? null;
    }
}
