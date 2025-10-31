<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\DatetimeFunction;

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Tourze\DoctrineFunctionCollection\ChainFunction;

class Day extends ChainFunction
{
    private ?string $platformClass = null;

    public function getInner(string $name): FunctionNode
    {
        if (null === $this->platformClass) {
            return new \DoctrineExtensions\Query\Mysql\Day($name);
        }

        switch ($this->platformClass) {
            case SQLitePlatform::class:
                return new \DoctrineExtensions\Query\Sqlite\Day($name);
            case PostgreSQLPlatform::class:
                return new \DoctrineExtensions\Query\Postgresql\Day($name);
            case AbstractMySQLPlatform::class:
            default:
                return new \DoctrineExtensions\Query\Mysql\Day($name);
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

        return $this->inner->getSql($sqlWalker);
    }
}
