<?php

namespace Ledc\DaDa\Parameters;

use Ledc\DaDa\Config;
use Ledc\DaDa\Contracts\Callback;
use Ledc\SupportSdk\Parameters;

/**
 * 达达秒送配送单订单状态回调的报文
 */
class Notify extends Parameters implements Callback
{
    /**
     * 相应报文
     * - 如回调成功及接口请求code返回200，如不成功达达会进行重试。
     */
    public const RESPONSE = [
        // 订单状态回调通知
        'code' => 200,
        'msg' => 'success'
    ];
    /**
     * 达达物流订单号，默认为空
     * @var string
     */
    protected string $client_id = '';
    /**
     * 第三方订单ID，对应下单接口中的origin_id
     * @var string
     */
    protected string $order_id;
    /**
     * 订单状态
     * - 待接单＝1,待取货＝2,骑士到店=100,配送中＝3,已完成＝4,已取消＝5,
     * - 已追加待接单=8,妥投异常之物品返回中=9, 妥投异常之物品返回完成=10,
     * - 售后取件单送达门店=6, 创建达达运单失败=1000
     * @var int|null
     */
    protected ?int $order_status = null;
    /**
     * 重复回传状态原因(1-重新分配骑士，2-骑士转单)
     * @var int|null
     */
    protected ?int $repeat_reason_type = null;
    /**
     * 订单取消原因,其他状态下默认值为空字符串
     * @var string
     */
    protected string $cancel_reason = '';
    /**
     * 订单取消原因来源(1:达达配送员取消；2:商家主动取消；3:系统或客服取消；0:默认值)
     * @var int
     */
    protected int $cancel_from = 0;
    /**
     * 更新时间
     * - 时间戳除了创建达达运单失败=1000的精确毫秒，其他时间戳精确到秒
     * @var int
     */
    protected int $update_time;
    /**
     * 报文的数据签名
     * @var string
     */
    protected string $signature;
    /**
     * 达达配送员id，接单以后会传
     * @var int|null
     */
    protected ?int $dm_id = null;
    /**
     * 配送员姓名，接单以后会传
     * @var string|null
     */
    protected ?string $dm_name = null;
    /**
     * 配送员手机号，接单以后会传
     * @var string|null
     */
    protected ?string $dm_mobile = null;
    /**
     * 收货码
     * @var string|null
     */
    protected ?string $finish_code = null;

    /**
     * 构造函数
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);
        $this->validate($properties);
    }

    /**
     * 验证参数
     * @param array $properties
     * @return void
     */
    protected function validate(array $properties): void
    {
        Config::verifySignature($this);
    }

    /**
     * 达达物流订单号
     * @return string
     */
    public function getClientId(): string
    {
        return $this->client_id;
    }

    /**
     * 第三方订单ID
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    /**
     * 订单状态
     * @return int|null
     */
    public function getOrderStatus(): ?int
    {
        return $this->order_status;
    }

    /**
     * 重复回传状态原因
     * @return int|null
     */
    public function getRepeatReasonType(): ?int
    {
        return $this->repeat_reason_type;
    }

    /**
     * 订单取消原因
     * @return string
     */
    public function getCancelReason(): string
    {
        return $this->cancel_reason;
    }

    /**
     * 订单取消原因来源
     * @return int
     */
    public function getCancelFrom(): int
    {
        return $this->cancel_from;
    }

    /**
     * 更新时间
     * - 时间戳除了创建达达运单失败=1000的精确毫秒，其他时间戳精确到秒
     * @return int
     */
    public function getUpdateTime(): int
    {
        return $this->update_time;
    }

    /**
     * 报文的数据签名
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * 达达配送员id
     * @return int|null
     */
    public function getDmId(): ?int
    {
        return $this->dm_id;
    }

    /**
     * 配送员姓名
     * @return string|null
     */
    public function getDmName(): ?string
    {
        return $this->dm_name;
    }

    /**
     * 达达配送员手机号
     * @return string|null
     */
    public function getDmMobile(): ?string
    {
        return $this->dm_mobile;
    }

    /**
     * 收货码
     * @return string|null
     */
    public function getFinishCode(): ?string
    {
        return $this->finish_code;
    }

    /**
     * 获取必填字段
     * @return string[]
     */
    protected function getRequiredKeys(): array
    {
        return ['order_id', 'cancel_from', 'update_time', 'signature'];
    }
}