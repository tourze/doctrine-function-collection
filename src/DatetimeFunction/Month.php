<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\DatetimeFunction;

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Tourze\DoctrineFunctionCollection\ChainFunction;

class Month extends ChainFunction
{
    private ?string $platformClass = null;

    /** @var array<string, mixed> */
    private array $parsedData = [];

    public function getInner(string $name): FunctionNode
    {
        if (null === $this->platformClass) {
            return new \DoctrineExtensions\Query\Mysql\Month($name);
        }

        switch ($this->platformClass) {
            case SQLitePlatform::class:
                return new \DoctrineExtensions\Query\Sqlite\Month($name);
            case PostgreSQLPlatform::class:
                return new \DoctrineExtensions\Query\Postgresql\Month($name);
            case AbstractMySQLPlatform::class:
            default:
                return new \DoctrineExtensions\Query\Mysql\Month($name);
        }
    }

    public function parse(Parser $parser): void
    {
        parent::parse($parser);

        // Store parsed data from the inner function
        $reflection = new \ReflectionObject($this->inner);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $this->parsedData[$property->getName()] = $property->getValue($this->inner);
        }
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();

        if ($platform instanceof SQLitePlatform) {
            $this->platformClass = SQLitePlatform::class;
        } elseif ($platform instanceof PostgreSQLPlatform) {
            $this->platformClass = PostgreSQLPlatform::class;
        } else {
            $this->platformClass = AbstractMySQLPlatform::class;
        }

        $this->inner = $this->getInner($this->name);

        // Restore parsed data to the new inner function
        $reflection = new \ReflectionObject($this->inner);
        foreach ($this->parsedData as $propertyName => $value) {
            if ($reflection->hasProperty($propertyName)) {
                $property = $reflection->getProperty($propertyName);
                $property->setAccessible(true);
                $property->setValue($this->inner, $value);
            }
        }

        return $this->inner->getSql($sqlWalker);
    }
}
