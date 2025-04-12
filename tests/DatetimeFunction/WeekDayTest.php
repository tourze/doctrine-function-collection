<?php

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use DoctrineExtensions\Query\Mysql\WeekDay as MysqlWeekDay;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\WeekDay;

/**
 * 测试WeekDay函数
 */
class WeekDayTest extends TestCase
{
    /**
     * 测试WeekDay函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $WeekDay = new WeekDay('WeekDay');
        $inner = $WeekDay->getInner('WeekDay');

        $this->assertInstanceOf(MysqlWeekDay::class, $inner);
    }

    /**
     * 测试WeekDay函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new WeekDay('WeekDay');
        $inner = $function->getInner('WeekDay');

        $this->assertInstanceOf(MysqlWeekDay::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('WeekDay');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $WeekDay = new WeekDay('WeekDay');
        $this->assertInstanceOf(WeekDay::class, $WeekDay);
    }
}
