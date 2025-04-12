<?php

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\Year as MysqlYear;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Year;

/**
 * 测试Year函数
 */
class YearTest extends TestCase
{
    /**
     * 测试Year函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Year = new Year('Year');
        $inner = $Year->getInner('Year');

        $this->assertInstanceOf(MysqlYear::class, $inner);
    }

    /**
     * 测试Year函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Year('Year');
        $inner = $function->getInner('Year');

        $this->assertInstanceOf(MysqlYear::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Year');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Year = new Year('Year');
        $this->assertInstanceOf(Year::class, $Year);
    }
}
