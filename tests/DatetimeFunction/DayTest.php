<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Day as MysqlDay;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Day;

/**
 * 测试Day函数
 *
 * @internal
 */
#[CoversClass(Day::class)]
final class DayTest extends TestCase
{
    /**
     * 测试Day函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $day = new Day('DAY');
        $inner = $day->getInner('DAY');

        $this->assertInstanceOf(MysqlDay::class, $inner);
    }

    /**
     * 测试Day函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Day('DAY');
        $inner = $function->getInner('DAY');

        $this->assertInstanceOf(MysqlDay::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('DAY');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $day = new Day('DAY');
        $this->assertInstanceOf(Day::class, $day);
    }
}
