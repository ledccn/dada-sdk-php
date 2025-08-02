# 说明

达达秒送开放平台SDK，首个版本发布于2025年8月1日

## 安装

`composer require ledc/dada`

## 使用说明

```php
use Ledc\Dada\Config;
use Ledc\Dada\Dada;

// 数据库或环境变量内的配置信息
$config = [
    'appKey' => 'app_key 应用ID',
    'appSecret' => 'app_secret 应用密钥',
    'sourceId' => 'source_id 商户编号',
    'sourceIdTest' => 'source_id 商户编号（测试环境）',
    'shopNoTest' => 'shop_no 门店编号（测试环境）',
    'timeout' => 10,
    'debug' => true,
    'enabled' => true,
];

$dada = new Dada(new Config($config));
```

在创建实例后，所有的方法都可以由IDE自动补全；例如：

```php
/** @var \Ledc\Dada\Dada $dada */

// 获取达达秒送HTTP客户端（处理了签名逻辑），可以直接调用达达全部接口
$client = $dada->getClient();

// 封装的商户管理接口
$merchant = $dada->merchant();

// 封装的订单管理接口
$order = $dada->order();

// 封装的账户管理接口
$account = $dada->account();
```

## 官方文档
https://newopen.imdada.cn

## 待完成TOTO...

订单状态回调
https://newopen.imdada.cn/#/development/file/order

骑士申请取消订单
https://newopen.imdada.cn/#/development/file/applicationCancel

查看品类ID
https://newopen.imdada.cn/#/development/file/categoryList

门店信息变更通知
https://newopen.imdada.cn/#/development/file/shopMessageChangePost

## 捐赠

![reward](reward.png)
