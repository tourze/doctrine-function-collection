# Doctrine Function Collection

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-function-collection.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-function-collection)

A collection of Doctrine ORM SQL functions that can be used in DQL queries.

## Features

- Provides a unified interface for various SQL functions
- Supports date/time functions
- Supports string functions
- Supports JSON functions
- Easy to use and register with Doctrine

## Installation

```bash
composer require tourze/doctrine-function-collection
```

## Quick Start

Register the functions with Doctrine Configuration:

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

Use the functions in your DQL:

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

## Available Functions

### Date/Time Functions

- `Day` - Returns the day of the month (0-31)
- `Hour` - Returns the hour (0-23)
- `Minute` - Returns the minute (0-59) 
- `Month` - Returns the month (1-12)
- `Week` - Returns the week number
- `WeekDay` - Returns the weekday index
- `Year` - Returns the year

### String Functions

- `AnyValue` - Returns any value from a set
- `DateDiff` - Returns the difference between two dates
- `Field` - Returns the index position
- `FindInSet` - Returns the position in a set
- `IfElse` - If-else condition in SQL
- `Rand` - Random number generator

### JSON Functions

- `JsonArray` - Creates a JSON array
- `JsonContains` - Checks if JSON document contains specific value
- `JsonExtract` - Extracts value from JSON document
- `JsonLength` - Returns the length of JSON document
- `JsonSearch` - Searches JSON document

## Running Tests

To run the unit tests for this package:

```bash
# From the monorepo root directory
phpunit packages/doctrine-function-collection/tests
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
