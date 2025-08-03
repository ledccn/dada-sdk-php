<?php

namespace Ledc\DaDa\Parameters;

/**
 * 推送消息体
 */
trait HasMessageTypeBody
{
    /**
     * 1-骑士取消 2-门店审核（已废弃） 3-异常上报 4-门店状态变更（新增）
     * @var int
     */
    protected int $messageType;
    /**
     * 消息内容（json字符串）
     * @var string
     */
    protected string $messageBody;

    /**
     * @return int
     */
    public function getMessageType(): int
    {
        return $this->messageType;
    }

    /**
     * @return string
     */
    public function getMessageBody(): string
    {
        return $this->messageBody;
    }
}
