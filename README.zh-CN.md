# Doctrine 函数集合

[English](README.md) | [中文](README.zh-CN.md)

[![最新版本](https://img.shields.io/packagist/v/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)

一个可在DQL查询中使用的Doctrine ORM SQL函数集合。

## 功能特性

- 为各种SQL函数提供统一接口
- 支持日期/时间函数
- 支持字符串函数
- 支持JSON函数
- 易于使用并注册到Doctrine

## 安装

```bash
composer require tourze/doctrine-function-collection
```

## 快速开始

在Doctrine配置中注册函数：

```php
<?php

use Doctrine\ORM\Configuration;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Day;
use Tourze\DoctrineFunctionCollection\StringFunction\IfElse;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonContains;

/** @var Configuration $config */
$config->addCustomDatetimeFunction('day', Day::class);
$config->addCustomStringFunction('if', IfElse::class);
$config->addCustomStringFunction('json_contains', JsonContains::class);
```

在DQL中使用这些函数：

```php
$query = $entityManager->createQuery('
    SELECT e 
    FROM App\Entity\Event e 
    WHERE DAY(e.createdAt) = :day
    AND JSON_CONTAINS(e.properties, :value) = 1
');
$query->setParameters([
    'day' => 15,
    'value' => '"example"',
]);
```

## 可用函数

### 日期/时间函数

- `Day` - 返回月份中的日期（0-31）
- `Hour` - 返回小时（0-23）
- `Minute` - 返回分钟（0-59）
- `Month` - 返回月份（1-12）
- `Week` - 返回周数
- `WeekDay` - 返回星期几索引
- `Year` - 返回年份

### 字符串函数

- `AnyValue` - 从集合中返回任意值
- `DateDiff` - 返回两个日期之间的差值
- `Field` - 返回索引位置
- `FindInSet` - 返回集合中的位置
- `IfElse` - SQL中的if-else条件
- `Rand` - 随机数生成器

### JSON函数

- `JsonArray` - 创建JSON数组
- `JsonContains` - 检查JSON文档是否包含特定值
- `JsonExtract` - 从JSON文档中提取值
- `JsonLength` - 返回JSON文档的长度
- `JsonSearch` - 搜索JSON文档

## 运行测试

要为此包运行单元测试：

```bash
# 从monorepo根目录
phpunit packages/doctrine-function-collection/tests
```

## 贡献

请参阅[CONTRIBUTING.md](CONTRIBUTING.md)了解详情。

## 许可证

MIT许可证。详情请参阅[许可证文件](LICENSE)。
