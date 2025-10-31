<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Week as MysqlWeek;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Week;

/**
 * 测试Week函数
 *
 * @internal
 */
#[CoversClass(Week::class)]
final class WeekTest extends TestCase
{
    /**
     * 测试Week函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Week = new Week('Week');
        $inner = $Week->getInner('Week');

        $this->assertInstanceOf(MysqlWeek::class, $inner);
    }

    /**
     * 测试Week函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Week('Week');
        $inner = $function->getInner('Week');

        $this->assertInstanceOf(MysqlWeek::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Week');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Week = new Week('Week');
        $this->assertInstanceOf(Week::class, $Week);
    }
}
