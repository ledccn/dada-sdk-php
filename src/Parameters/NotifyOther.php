<?php

namespace Ledc\DaDa\Parameters;

use Ledc\DaDa\Contracts\Callback;
use Ledc\SupportSdk\Parameters;

/**
 * 其他类型的通知
 */
class NotifyOther extends Parameters implements Callback
{
    use HasMessageTypeBody;

    /**
     * 构造函数
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);
        $body = json_decode($this->getMessageBody(), true);
        $this->initProperties($body);
    }

    /**
     * 获取必填参数
     * @return string[]
     */
    protected function getRequiredKeys(): array
    {
        return ['messageType', 'messageBody'];
    }
}
