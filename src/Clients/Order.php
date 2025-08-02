<?php

namespace Ledc\DaDa\Clients;

use Ledc\DaDa\Enums\OrderCancelReasonIdEnums;
use RuntimeException;

/**
 * 订单管理
 */
class Order
{
    use HasClient;

    /**
     * 创建订单
     * - 调用该接口传入配送订单相关信息，达达将根据传入的配送信息实时计算运费并创建达达物流订单。
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->post('/api/order/addOrder', $data);
    }

    /**
     * 重新下单
     * - 同一个商户的单号(根据三方单号识别)如果已经在达达侧创建了订单，在该订单被取消(已取消=5)、拒收返还(妥投异常物品返还完成=10)后，可以调用该接口重发订单，达达将根据传入的配送信息重新计算运费并创建达达物流订单。
     * @param array $data
     * @return array
     */
    public function reorder(array $data): array
    {
        return $this->post('/api/order/reAddOrder', $data);
    }

    /**
     * 查询运费
     * @param array $data
     * @return array
     */
    public function queryDeliverFee(array $data): array
    {
        return $this->post('/api/order/queryDeliverFee', $data);
    }

    /**
     * 查询运费后下单（达达平台询价单号仅在3分钟内有效）
     * - 调用该接口传入查询运费接口返回的达达平台询价单号，达达将根据查询运费接口传入的订单信息创建达达物流订单，并使用询价时返回的运费，不会再重新计费。
     * @param string $deliveryNo 平台订单编号（达达平台询价单号仅在3分钟内有效）
     * @param string $info 是否重置订单备注等字段。true：重置，false或缺失：不重置
     * @param bool $enableReset 订单备注内容
     * @return array|bool|int|string
     */
    public function addAfterQuery(string $deliveryNo, string $info = '', bool $enableReset = false)
    {
        return $this->post('/api/order/addAfterQuery', [
            'deliveryNo' => $deliveryNo,
            'info' => $info,
            'enableReset' => $enableReset,
        ]);
    }

    /**
     * 加小费
     *  - 在订单处于待接单状态时，可以为订单添加小费。每次添加的小费将覆盖前一次的小费金额，再次通过该接口添加小费的金额需大于前一次。
     * @param string $order_id 第三方订单编号
     * @param float $tips 小费金额(精确到小数点后一位，单位：元)
     * @param string $info 备注(字段最大长度：512)
     * @return bool
     */
    public function addTip(string $order_id, float $tips, string $info = ''): bool
    {
        $this->post('/api/order/addTip', [
            'order_id' => $order_id,
            'tips' => round($tips, 1),
            'info' => $info,
        ]);
        return true;
    }

    /**
     * 查询订单详情
     * - 创建达达物流订单后，可查询订单状态、运费、骑手相关信息，接口调用请求说明。
     * - 订单接单后才会有骑手信息，接单后送达前支持查询骑士实时经纬度信息，送达后返回骑士送达时的经纬度。
     * @param string $order_id 第三方订单编号
     * @return array
     */
    public function query(string $order_id): array
    {
        return $this->post('/api/order/status/query', [
            'order_id' => $order_id
        ]);
    }

    /**
     * 取消订单
     * - 在订单待接单或待取货情况下，调用此接口可取消订单。
     * - 取消费用说明：接单1 分钟以内取消不扣违约金；
     * - 接单后1－15分钟内取消订单，运费退回。同时扣除2元作为给配送员的违约金；
     * - 配送员接单后15 分钟未到店，商户取消不扣违约金；
     * - 系统取消订单说明：超过72小时未接单系统自动取消。每天凌晨2点，取消大于72小时未完成的订单。
     * @param string $order_id 第三方订单编号
     * @param int $cancel_reason_id 取消原因ID 可以通过接口获取
     * @param string $cancel_reason 取消原因(当取消原因ID为其他时，此字段必填)
     * @return array
     */
    public function cancel(string $order_id, int $cancel_reason_id, string $cancel_reason = ''): array
    {
        if ($cancel_reason_id === OrderCancelReasonIdEnums::OTHER) {
            if (empty($cancel_reason)) {
                throw new RuntimeException('请填写取消原因');
            }
        }
        return $this->post('/api/order/formalCancel', [
            'order_id' => $order_id,
            'cancel_reason_id' => $cancel_reason_id,
            'cancel_reason' => $cancel_reason,
        ]);
    }

    /**
     * 获取取消原因
     * - 调用取消订单接口时，需要传递取消原因ID，通过此接口获取订单取消理由列表
     * @return array
     */
    public function cancelReasons(): array
    {
        return $this->post('/api/order/cancel/reasons');
    }

    /**
     * 追加订单
     * - 在商户侧订单被接单后，如产生了新的同方向订单，可以调用该接口将待接单的订单追加给同一配送员
     * - 1.追加的订单必须是该门店发出的待接单状态的订单；
     * - 2.只能从符合条件的骑士列表中选择配送员进行追加,（查询可追加骑士）；
     * - 3.追加后，需等待骑士在APP进行接单；
     * - 4.订单在追加中状态时，其他骑士不可见。
     * @param string $order_id 追加的第三方订单ID
     * @param int $transporter_id 追加的配送员ID（使用接口查询可追加的骑士）
     * @param string $shop_no 追加订单的门店编码
     * @return array|bool|int|string
     */
    public function appendOrder(string $order_id, int $transporter_id, string $shop_no)
    {
        return $this->post('/api/order/appoint/exist', [
            'order_id' => $order_id,
            'transporter_id' => $transporter_id,
            'shop_no' => $shop_no,
        ]);
    }

    /**
     * 取消追加订单
     * - 商户调用该接口取消已发布的追加订单
     * - 被取消的追加订单，状态变为待接单，其他配送员可见
     * @param string $order_id 追加的第三方订单ID
     * @return array|bool|int|string
     */
    public function appendCancel(string $order_id)
    {
        return $this->post('/api/order/appoint/cancel', [
            'order_id' => $order_id
        ]);
    }

    /**
     * 查询可追加骑士
     * - 商户调用该接口查询可追加订单的骑士列表，仅可查询到满足以下条件的骑士：
     * - 1. 骑士在1小时内接过此商户的订单，且订单未完成；
     * - 2. 骑士在当前商户接单数小于系统限定的指定商户接单总数；
     * - 3. 骑士在达达平台的接单数量未达上限。
     * @param string $shop_no 门店编码
     * @return array
     */
    public function queryAppendTransporter(string $shop_no): array
    {
        return $this->post('/api/order/appoint/list/transporter', [
            'shop_no' => $shop_no
        ]);
    }

    /**
     * 商家投诉达达
     * - 达达配送员接单后，商家如果对达达服务不满意，均可以使用该接口对达达进行投诉。
     * @param string $order_id 第三方订单编号
     * @param int $reason_id 投诉原因ID（使用接口查询投诉原因ID）
     * @return array|bool|int|string
     */
    public function complaintDada(string $order_id, int $reason_id)
    {
        return $this->post('/api/complaint/dada', [
            'order_id' => $order_id,
            'reason_id' => $reason_id,
        ]);
    }

    /**
     * 获取商家投诉达达原因
     * - 商家投诉达达，需要传递投诉原因ID，通过此接口获取投诉原因列表
     * @return array
     */
    public function complaintReasons(): array
    {
        return $this->post('/api/complaint/reasons');
    }

    /**
     * 商户确认物品已返还
     * - 在用户拒收骑手操作申请返还并通过后，订单状态将变为妥投异常物品返还中=9，骑手将物品返还商户侧;
     * - 商户在确认收到物品后，可调用该接口进行确认，确认后订单状态将变为妥投异常物品返还完成=10。
     * - 如商户侧不进行确认，达达侧会进行兜底确认。
     * @param string $order_id 第三方订单编号
     * @return array|bool|int|string
     */
    public function confirmGoods(string $order_id)
    {
        return $this->post('/api/order/confirm/goods', [
            'order_id' => $order_id
        ]);
    }

    /**
     * 查询骑士位置
     * - 接单后送达前支持查询骑士实时经纬度信息，送达后返回骑士送达时的经纬度。
     * @param array $orderIds 第三方订单号列表,最多传50个
     * @return array
     */
    public function queryTransporterPosition(array $orderIds): array
    {
        return $this->post('/api/order/transporter/position', [
            'orderIds' => $orderIds
        ]);
    }

    /**
     * 获取骑士配送信息H5页面
     * - 调用此接口可获取骑士配送信息H5页面链接
     * - 页面主要展示内容包括骑士所在位置、订单状态、骑士信息等。
     * - 仅展示查询订单接单至完成阶段的骑士轨迹，订单取消之后则不再展示。
     * @param string $order_id 第三方订单编号
     * @return array
     */
    public function queryTransporterH5(string $order_id): array
    {
        return $this->post('/api/order/transporter/track', [
            'order_id' => $order_id
        ]);
    }

    /**
     * 更新取件码和货架号
     * @param string $originId 三方单号
     * @param int|null $type 操作类型类型：1-更新；首次传入或更新时使用，更新后之前传入的取货码和货架号作废。2-取货；骑士取走时调用。3-撤销；因某些原因撤柜调用，取货码和货架号将被置为空
     * @param string|null $fetchCode 取货码。请注意，传入null不进行更新，直接返回ok，传入空字符串会进行更新
     * @param array|null $shelfCode 货架号。请注意，传入null不进行更新，直接返回ok，传入空list会进行更新
     * @return array
     */
    public function updateFetchCode(string $originId, int $type, ?string $fetchCode = null, ?array $shelfCode = null): array
    {
        return $this->post('/api/fetchCode/update', [
            'originId' => $originId,
            'type' => $type,
            'fetchCode' => $fetchCode,
            'shelfCode' => $shelfCode,
        ]);
    }

    /**
     * 商户确认售后单交接完成
     * - 售后取件单，骑士送达门店后，门店核对商品无误后确认交接，该场景下调用该接口通知达达商品已确认交接，确认后骑士可操作完成订单。
     * @param string $order_id 第三方订单编号
     * @return array
     */
    public function afterSaleConfirm(string $order_id): array
    {
        return $this->post('/api/order/afterSale/confirm', [
            'order_id' => $order_id
        ]);
    }
}
