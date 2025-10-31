<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\StringFunction;

use DoctrineExtensions\Query\Mysql\AnyValue as MysqlAnyValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\StringFunction\AnyValue;

/**
 * 测试AnyValue函数
 *
 * @internal
 */
#[CoversClass(AnyValue::class)]
final class AnyValueTest extends TestCase
{
    /**
     * 测试AnyValue函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $AnyValue = new AnyValue('AnyValue');
        $inner = $AnyValue->getInner('AnyValue');

        $this->assertInstanceOf(MysqlAnyValue::class, $inner);
    }

    /**
     * 测试AnyValue函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new AnyValue('AnyValue');
        $inner = $function->getInner('AnyValue');

        $this->assertInstanceOf(MysqlAnyValue::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('AnyValue');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $AnyValue = new AnyValue('AnyValue');
        $this->assertInstanceOf(AnyValue::class, $AnyValue);
    }
}
