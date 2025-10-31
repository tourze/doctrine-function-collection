# Doctrine 函数集合

[English](README.md) | [中文](README.zh-CN.md)

[![最新版本](https://img.shields.io/packagist/v/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)
[![PHP版本要求](https://img.shields.io/packagist/php-v/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)
[![许可证](https://img.shields.io/packagist/l/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)
[![构建状态](https://img.shields.io/travis/tourze/doctrine-function-collection/master.svg?style=flat-square)](https://travis-ci.org/tourze/doctrine-function-collection)
[![质量评分](https://img.shields.io/scrutinizer/g/tourze/doctrine-function-collection.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/doctrine-function-collection)
[![代码覆盖率](https://img.shields.io/codecov/c/github/tourze/doctrine-function-collection.svg?style=flat-square)](https://codecov.io/gh/tourze/doctrine-function-collection)
[![下载量](https://img.shields.io/packagist/dt/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)

一个可在DQL查询中使用的Doctrine ORM SQL函数集合，通过链式函数模式为各种数据库函数提供统一接口。

## 功能特性

- **统一接口**: 为SQL函数提供一致的ChainFunction抽象
- **日期/时间函数**: 完整的日期和时间操作函数集
- **字符串函数**: 各种字符串操作和条件函数
- **JSON函数**: 完整的JSON文档处理能力
- **易于集成**: 与Doctrine ORM配置简单集成
- **类型安全**: PHP 8.2+严格类型支持
- **全面测试**: PHPUnit完整测试覆盖

## 系统要求

- PHP 8.2 或更高版本
- Doctrine ORM 3.0 或更高版本
- beberlei/doctrineextensions 1.5.0 或更高版本
- scienta/doctrine-json-functions 6.3.0 或更高版本

## 安装

```bash
composer require tourze/doctrine-function-collection
```

## 快速开始

### 1. 在Doctrine中注册函数

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

### 2. 在DQL中使用函数

在DQL查询中使用注册的函数：

```php
$query = $entityManager->createQuery('
    SELECT e 
    FROM App\Entity\Event e 
    WHERE DAY(e.createTime) = :day
    AND JSON_CONTAINS(e.properties, :value) = 1
');
$query->setParameters([
    'day' => 15,
    'value' => '"example"',
]);
```

### 3. 链式函数模式

所有函数都扩展了`ChainFunction`抽象类，提供了一致的接口：

```php
<?php

use Tourze\DoctrineFunctionCollection\ChainFunction;

class CustomFunction extends ChainFunction
{
    public function getInner(string $name): FunctionNode
    {
        return new \DoctrineExtensions\Query\Mysql\CustomFunction($name);
    }
}
```

## 可用函数

### 日期/时间函数

所有日期/时间函数都扩展了`ChainFunction`并包装了相应的MySQL函数：

| 函数 | 描述 | 使用示例 |
|------|------|----------|
| `Day` | 返回月份中的日期（0-31） | `DAY(e.createdAt)` |
| `Hour` | 返回小时（0-23） | `HOUR(e.createdAt)` |
| `Minute` | 返回分钟（0-59） | `MINUTE(e.createdAt)` |
| `Month` | 返回月份（1-12） | `MONTH(e.createdAt)` |
| `Week` | 返回周数 | `WEEK(e.createdAt)` |
| `WeekDay` | 返回星期几索引 | `WEEKDAY(e.createdAt)` |
| `Year` | 返回年份 | `YEAR(e.createdAt)` |

### 字符串函数

字符串操作和条件函数：

| 函数 | 描述 | 使用示例 |
|------|------|----------|
| `AnyValue` | 从集合中返回任意值 | `ANY_VALUE(e.field)` |
| `DateDiff` | 返回两个日期之间的差值 | `DATEDIFF(e.endDate, e.startDate)` |
| `Field` | 返回索引位置 | `FIELD(e.status, 'active', 'inactive')` |
| `FindInSet` | 返回集合中的位置 | `FIND_IN_SET(e.tag, e.tags)` |
| `IfElse` | SQL中的if-else条件 | `IF(e.active = 1, 'Active', 'Inactive')` |
| `Rand` | 随机数生成器 | `RAND()` |

### JSON函数

JSON文档处理函数：

| 函数 | 描述 | 使用示例 |
|------|------|----------|
| `JsonArray` | 创建JSON数组 | `JSON_ARRAY(e.field1, e.field2)` |
| `JsonContains` | 检查JSON文档是否包含特定值 | `JSON_CONTAINS(e.data, '"value"')` |
| `JsonExtract` | 从JSON文档中提取值 | `JSON_EXTRACT(e.data, '$.field')` |
| `JsonLength` | 返回JSON文档的长度 | `JSON_LENGTH(e.data)` |
| `JsonSearch` | 搜索JSON文档 | `JSON_SEARCH(e.data, 'one', 'value')` |

## 架构

### 链式函数模式

此包实现了链式函数模式，所有SQL函数都扩展了抽象的`ChainFunction`类：

```php
abstract class ChainFunction extends FunctionNode
{
    protected FunctionNode $inner;
    
    abstract public function getInner(string $name): FunctionNode;
    
    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->inner->getSql($sqlWalker);
    }
    
    public function parse(Parser $parser): void
    {
        $this->inner->parse($parser);
    }
}
```

此设计提供了：
- **一致性**: 所有函数都遵循相同的接口模式
- **可扩展性**: 通过扩展ChainFunction轻松添加新函数
- **可维护性**: 函数委托的集中化逻辑
- **类型安全**: PHP 8.2+功能的强类型支持

## 测试

要为此包运行单元测试：

```bash
# 从monorepo根目录
./vendor/bin/phpunit packages/doctrine-function-collection/tests

# 运行带覆盖率报告的测试
./vendor/bin/phpunit packages/doctrine-function-collection/tests --coverage-html coverage

# 运行PHPStan分析
php -d memory_limit=2G ./vendor/bin/phpstan analyse packages/doctrine-function-collection
```

## 贡献

请参阅[CONTRIBUTING.md](CONTRIBUTING.md)了解详情。

## 安全

如果您发现任何安全相关问题，请发送邮件至security@tourze.com而不是使用issue tracker。

## 许可证

MIT许可证。详情请参阅[许可证文件](LICENSE)。
