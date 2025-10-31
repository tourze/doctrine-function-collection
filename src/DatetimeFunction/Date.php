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

class Date extends ChainFunction
{
    private ?string $platformClass = null;

    private mixed $dateExpression = null;

    public function getInner(string $name): FunctionNode
    {
        if (null === $this->platformClass) {
            return new \DoctrineExtensions\Query\Mysql\Date($name);
        }

        switch ($this->platformClass) {
            case SQLitePlatform::class:
                return new \DoctrineExtensions\Query\Sqlite\Date($name);
            case PostgreSQLPlatform::class:
                return new \DoctrineExtensions\Query\Postgresql\Date($name);
            case AbstractMySQLPlatform::class:
            default:
                return new \DoctrineExtensions\Query\Mysql\Date($name);
        }
    }

    public function parse(Parser $parser): void
    {
        // 先调用父类的 parse 方法，让 inner 对象解析参数
        parent::parse($parser);

        // 保存解析的日期表达式
        // 检查 inner 对象是否是预期的类型
        if ($this->inner instanceof \DoctrineExtensions\Query\Mysql\Date
            || $this->inner instanceof \DoctrineExtensions\Query\Sqlite\Date
            || $this->inner instanceof \DoctrineExtensions\Query\Postgresql\Date) {
            $this->dateExpression = $this->inner->date;
        }
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $this->determinePlatformClass($sqlWalker);

        // 重新创建 inner 对象
        $this->inner = $this->getInner($this->name);

        // 将保存的日期表达式传递给新的 inner 对象
        $this->restoreDateExpression();

        return $this->inner->getSql($sqlWalker);
    }

    private function determinePlatformClass(SqlWalker $sqlWalker): void
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();

        if ($platform instanceof SQLitePlatform) {
            $this->platformClass = SQLitePlatform::class;
        } elseif ($platform instanceof PostgreSQLPlatform) {
            $this->platformClass = PostgreSQLPlatform::class;
        } else {
            $this->platformClass = AbstractMySQLPlatform::class;
        }
    }

    private function restoreDateExpression(): void
    {
        if (null === $this->dateExpression) {
            return;
        }

        if ($this->inner instanceof \DoctrineExtensions\Query\Mysql\Date
            || $this->inner instanceof \DoctrineExtensions\Query\Sqlite\Date
            || $this->inner instanceof \DoctrineExtensions\Query\Postgresql\Date) {
            $this->inner->date = $this->dateExpression;
        }
    }
}
