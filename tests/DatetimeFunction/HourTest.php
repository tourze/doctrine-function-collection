<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Hour as MysqlHour;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Hour;

/**
 * 测试Hour函数
 *
 * @internal
 */
#[CoversClass(Hour::class)]
final class HourTest extends TestCase
{
    /**
     * 测试Hour函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Hour = new Hour('Hour');
        $inner = $Hour->getInner('Hour');

        $this->assertInstanceOf(MysqlHour::class, $inner);
    }

    /**
     * 测试Hour函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Hour('Hour');
        $inner = $function->getInner('Hour');

        $this->assertInstanceOf(MysqlHour::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Hour');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Hour = new Hour('Hour');
        $this->assertInstanceOf(Hour::class, $Hour);
    }
}
