<?php

namespace Tourze\DoctrineFunctionCollection\Tests\StringFunction;

use DoctrineExtensions\Query\Mysql\FindInSet as MysqlFindInSet;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\StringFunction\FindInSet;

/**
 * 测试FindInSet函数
 */
class FindInSetTest extends TestCase
{
    /**
     * 测试FindInSet函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $FindInSet = new FindInSet('FindInSet');
        $inner = $FindInSet->getInner('FindInSet');

        $this->assertInstanceOf(MysqlFindInSet::class, $inner);
    }

    /**
     * 测试FindInSet函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new FindInSet('FindInSet');
        $inner = $function->getInner('FindInSet');

        $this->assertInstanceOf(MysqlFindInSet::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('FindInSet');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $FindInSet = new FindInSet('FindInSet');
        $this->assertInstanceOf(FindInSet::class, $FindInSet);
    }
}
