<?php

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Month as MysqlMonth;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Month;

/**
 * 测试Month函数
 */
class MonthTest extends TestCase
{
    /**
     * 测试Month函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Month = new Month('Month');
        $inner = $Month->getInner('Month');

        $this->assertInstanceOf(MysqlMonth::class, $inner);
    }

    /**
     * 测试Month函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Month('Month');
        $inner = $function->getInner('Month');

        $this->assertInstanceOf(MysqlMonth::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Month');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Month = new Month('Month');
        $this->assertInstanceOf(Month::class, $Month);
    }
}
