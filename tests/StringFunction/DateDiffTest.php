<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\StringFunction;

use DoctrineExtensions\Query\Mysql\DateDiff as MysqlDateDiff;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\StringFunction\DateDiff;

/**
 * 测试DateDiff函数
 *
 * @internal
 */
#[CoversClass(DateDiff::class)]
final class DateDiffTest extends TestCase
{
    /**
     * 测试DateDiff函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $DateDiff = new DateDiff('DateDiff');
        $inner = $DateDiff->getInner('DateDiff');

        $this->assertInstanceOf(MysqlDateDiff::class, $inner);
    }

    /**
     * 测试DateDiff函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new DateDiff('DateDiff');
        $inner = $function->getInner('DateDiff');

        $this->assertInstanceOf(MysqlDateDiff::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('DateDiff');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $DateDiff = new DateDiff('DateDiff');
        $this->assertInstanceOf(DateDiff::class, $DateDiff);
    }
}
