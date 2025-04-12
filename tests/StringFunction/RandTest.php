<?php

namespace Tourze\DoctrineFunctionCollection\Tests\StringFunction;

use DoctrineExtensions\Query\Mysql\Rand as MysqlRand;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\StringFunction\Rand;

/**
 * 测试Rand函数
 */
class RandTest extends TestCase
{
    /**
     * 测试Rand函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Rand = new Rand('Rand');
        $inner = $Rand->getInner('Rand');

        $this->assertInstanceOf(MysqlRand::class, $inner);
    }

    /**
     * 测试Rand函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Rand('Rand');
        $inner = $function->getInner('Rand');

        $this->assertInstanceOf(MysqlRand::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Rand');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Rand = new Rand('Rand');
        $this->assertInstanceOf(Rand::class, $Rand);
    }
}
