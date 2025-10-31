# Doctrine Function Collection

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)
[![PHP Version Require](https://img.shields.io/packagist/php-v/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)
[![License](https://img.shields.io/packagist/l/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)
[![Build Status](https://img.shields.io/travis/tourze/doctrine-function-collection/master.svg?style=flat-square)](https://travis-ci.org/tourze/doctrine-function-collection)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/doctrine-function-collection.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/doctrine-function-collection)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/doctrine-function-collection.svg?style=flat-square)](https://codecov.io/gh/tourze/doctrine-function-collection)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)

A collection of Doctrine ORM SQL functions that can be used in DQL queries, providing a unified interface for various database functions through a chain function pattern.

## Features

- **Unified Interface**: Provides a consistent ChainFunction abstraction for SQL functions
- **Date/Time Functions**: Complete set of date and time manipulation functions
- **String Functions**: Various string manipulation and conditional functions
- **JSON Functions**: Full JSON document processing capabilities
- **Easy Integration**: Simple registration with Doctrine ORM configuration
- **Type Safety**: PHP 8.2+ with strict typing support
- **Comprehensive Testing**: Full test coverage with PHPUnit

## Requirements

- PHP 8.2 or higher
- Doctrine ORM 3.0 or higher
- beberlei/doctrineextensions 1.5.0 or higher
- scienta/doctrine-json-functions 6.3.0 or higher

## Installation

```bash
composer require tourze/doctrine-function-collection
```

## Quick Start

### 1. Register Functions with Doctrine

Register the functions with your Doctrine Configuration:

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

### 2. Use Functions in DQL

Use the registered functions in your DQL queries:

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

### 3. Chain Function Pattern

All functions extend the `ChainFunction` abstract class, providing a consistent interface:

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

## Available Functions

### Date/Time Functions

All date/time functions extend `ChainFunction` and wrap the corresponding MySQL functions:

| Function | Description | Usage Example |
|----------|-------------|---------------|
| `Day` | Returns the day of the month (0-31) | `DAY(e.createdAt)` |
| `Hour` | Returns the hour (0-23) | `HOUR(e.createdAt)` |
| `Minute` | Returns the minute (0-59) | `MINUTE(e.createdAt)` |
| `Month` | Returns the month (1-12) | `MONTH(e.createdAt)` |
| `Week` | Returns the week number | `WEEK(e.createdAt)` |
| `WeekDay` | Returns the weekday index | `WEEKDAY(e.createdAt)` |
| `Year` | Returns the year | `YEAR(e.createdAt)` |

### String Functions

String manipulation and conditional functions:

| Function | Description | Usage Example |
|----------|-------------|---------------|
| `AnyValue` | Returns any value from a set | `ANY_VALUE(e.field)` |
| `DateDiff` | Returns the difference between two dates | `DATEDIFF(e.endDate, e.startDate)` |
| `Field` | Returns the index position | `FIELD(e.status, 'active', 'inactive')` |
| `FindInSet` | Returns the position in a set | `FIND_IN_SET(e.tag, e.tags)` |
| `IfElse` | If-else condition in SQL | `IF(e.active = 1, 'Active', 'Inactive')` |
| `Rand` | Random number generator | `RAND()` |

### JSON Functions

JSON document processing functions:

| Function | Description | Usage Example |
|----------|-------------|---------------|
| `JsonArray` | Creates a JSON array | `JSON_ARRAY(e.field1, e.field2)` |
| `JsonContains` | Checks if JSON document contains specific value | `JSON_CONTAINS(e.data, '"value"')` |
| `JsonExtract` | Extracts value from JSON document | `JSON_EXTRACT(e.data, '$.field')` |
| `JsonLength` | Returns the length of JSON document | `JSON_LENGTH(e.data)` |
| `JsonSearch` | Searches JSON document | `JSON_SEARCH(e.data, 'one', 'value')` |

## Architecture

### ChainFunction Pattern

This package implements a chain function pattern where all SQL functions extend the abstract `ChainFunction` class:

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

This design provides:
- **Consistency**: All functions follow the same interface pattern
- **Extensibility**: Easy to add new functions by extending ChainFunction
- **Maintainability**: Centralized logic for function delegation
- **Type Safety**: Strong typing with PHP 8.2+ features

## Testing

To run the unit tests for this package:

```bash
# From the monorepo root directory
./vendor/bin/phpunit packages/doctrine-function-collection/tests

# Run with coverage
./vendor/bin/phpunit packages/doctrine-function-collection/tests --coverage-html coverage

# Run PHPStan analysis
php -d memory_limit=2G ./vendor/bin/phpstan analyse packages/doctrine-function-collection
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@tourze.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
