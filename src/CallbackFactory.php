<?php

namespace Ledc\DaDa;

use Ledc\DaDa\Contracts\Callback;
use Ledc\DaDa\Enums\NotifyMessageTypeEnums;
use Ledc\DaDa\Parameters\Notify;
use Ledc\DaDa\Parameters\NotifyCourier;
use Ledc\DaDa\Parameters\NotifyOther;
use Ledc\DaDa\Parameters\NotifyShopUpdated;

/**
 * 创建工厂，创建回调通知报文对象
 */
class CallbackFactory
{
    /**
     * 创建
     * @param array $payload 回调数据数组
     * @return Callback|Notify|NotifyCourier|NotifyShopUpdated|NotifyOther
     */
    public static function create(array $payload): Callback
    {
        $messageType = $payload['messageType'] ?? null;
        $messageBody = $payload['messageBody'] ?? null;
        $order_id = $payload['order_id'] ?? null;
        // 是否存在消息类型&消息体
        if ($order_id && (is_null($messageType) || is_null($messageBody))) {
            // 订单状态回调报文
            return new Notify($payload);
        }

        switch ((int)$messageType) {
            case NotifyMessageTypeEnums::COURIER_CANCEL:
                // 配送员取消订单
                return new NotifyCourier($payload);
            case NotifyMessageTypeEnums::STORE_STATUS_CHANGE:
                // 门店信息变更通知
                return new NotifyShopUpdated($payload);
            default:
                return new NotifyOther($payload);
        }
    }
}
