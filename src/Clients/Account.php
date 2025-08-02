<?php

namespace Ledc\DaDa\Clients;

/**
 * 账户管理
 */
class Account
{
    use HasClient;

    /**
     * 查询账户余额
     * - 使用此接口可以查询运费账户或红包账户的余额。
     * @param int $category 查询运费账户类型（1：运费账户；2：红包账户，3：所有），默认查询运费账户余额
     * @param string|null $shop_no 门店编号。如需要查询大客户下独立结算子门店余额，则需要传入(查询大客户账户则不传)，如门店非独立结算则返回0
     * @return array
     */
    public function balance(int $category = 1, ?string $shop_no = null): array
    {
        return $this->post('/api/balance/query', [
            'category' => $category,
            'shop_no' => $shop_no,
        ]);
    }

    /**
     * 获取充值链接
     * @param float $amount 充值金额（单位元，可以精确到分）
     * @param string $category 生成链接适应场景（category有二种类型值：PC、H5）
     * @param string|null $notify_url 支付成功后跳转的页面（支付宝在支付成功后可以跳转到某个指定的页面，微信支付不支持）
     * @param string|null $shop_no 门店编号。如需要为商户账号下独立结算子门店充值，则需要传入(充值到大客户账户则不传)，如门店非独立结算则返回错误
     * @return string 充值的链接
     */
    public function recharge(float $amount, string $category, ?string $notify_url = null, ?string $shop_no = null): string
    {
        return $this->post('/api/recharge', [
            'amount' => $amount,
            'category' => $category,
            'notify_url' => $notify_url,
            'shop_no' => $shop_no,
        ]);
    }
}
