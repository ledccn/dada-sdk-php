<?php

namespace Ledc\DaDa\Clients;

/**
 * 商户管理
 */
class Merchant
{
    use HasClient;

    /**
     * 注册商户账号
     */
    public const REGISTER = '/merchantApi/merchant/add';

    /**
     * 查询城市码
     * @return array
     */
    public function cityCodeList(): array
    {
        return $this->post('/api/cityCode/list');
    }

    /**
     * 注册商户账号
     * - 商户注册接口，商户注册后将直接与开发者进行绑定，系统自动生成商户登录初始密码会以短信形式发送到注册手机号。
     * @param array $data
     * @return int 商户编号
     */
    public function register(array $data): int
    {
        return $this->post(self::REGISTER, $data);
    }

    /**
     * 新增门店
     * - 1.门店编码可自定义，但必须唯一，若不填写，则系统自动生成。发单时用于确认发单门店
     * - 2.如果需要使用达达商家App发单，请设置登陆达达商家App的账号（必须手机号）和密码
     * - 3.该接口为批量接口,业务参数为数组
     * @param array $data
     * @return array
     */
    public function createShop(array $data): array
    {
        return $this->post('/api/shop/add', $data);
    }

    /**
     * 更新门店
     * - 门店编码是必传参数。其他参数，需要更新则传，且不能为空。
     * @param array $data
     * @return bool
     */
    public function updateShop(array $data): bool
    {
        $this->post('/api/shop/update', $data);
        return true;
    }

    /**
     * 查询门店详情
     * @param string $origin_shop_id 门店编码
     * @return array
     */
    public function shopDetail(string $origin_shop_id): array
    {
        return $this->post('/api/shop/detail', ['origin_shop_id' => $origin_shop_id]);
    }
}
