<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Month as MysqlMonth;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Month;

/**
 * 测试Month函数
 *
 * @internal
 */
#[CoversClass(Month::class)]
final class MonthTest extends TestCase
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

    /**
     * 测试parse方法继承自ChainFunction
     */
    public function testParseInheritsFromChainFunction(): void
    {
        $monthFunction = new Month('MONTH');

        $reflection = new \ReflectionClass($monthFunction);
        $parseMethod = $reflection->getMethod('parse');

        $this->assertTrue($parseMethod->isPublic());
        $this->assertEquals('parse', $parseMethod->getName());
        $this->assertEquals(Month::class, $parseMethod->getDeclaringClass()->getName());
    }
}
