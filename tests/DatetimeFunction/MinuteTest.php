<?php

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Minute as MysqlMinute;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Minute;

/**
 * 测试Minute函数
 */
class MinuteTest extends TestCase
{
    /**
     * 测试Minute函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Minute = new Minute('Minute');
        $inner = $Minute->getInner('Minute');

        $this->assertInstanceOf(MysqlMinute::class, $inner);
    }

    /**
     * 测试Minute函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Minute('Minute');
        $inner = $function->getInner('Minute');

        $this->assertInstanceOf(MysqlMinute::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Minute');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Minute = new Minute('Minute');
        $this->assertInstanceOf(Minute::class, $Minute);
    }
}
