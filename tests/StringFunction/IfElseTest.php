<?php

namespace Tourze\DoctrineFunctionCollection\Tests\StringFunction;

use DoctrineExtensions\Query\Mysql\IfElse as MysqlIfElse;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\StringFunction\IfElse;

/**
 * 测试IfElse函数
 */
class IfElseTest extends TestCase
{
    /**
     * 测试IfElse函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $ifElse = new IfElse('IF');
        $inner = $ifElse->getInner('IF');

        $this->assertInstanceOf(MysqlIfElse::class, $inner);
    }

    /**
     * 测试IfElse函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new IfElse('IF');
        $inner = $function->getInner('IF');

        $this->assertInstanceOf(MysqlIfElse::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('IF');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $ifElse = new IfElse('IF');
        $this->assertInstanceOf(IfElse::class, $ifElse);
    }
}
