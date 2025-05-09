<?php

namespace Tourze\DoctrineFunctionCollection\Tests\StringFunction;

use DoctrineExtensions\Query\Mysql\Field as MysqlField;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\StringFunction\Field;

/**
 * 测试Field函数
 */
class FieldTest extends TestCase
{
    /**
     * 测试Field函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $Field = new Field('Field');
        $inner = $Field->getInner('Field');

        $this->assertInstanceOf(MysqlField::class, $inner);
    }

    /**
     * 测试Field函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new Field('Field');
        $inner = $function->getInner('Field');

        $this->assertInstanceOf(MysqlField::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('Field');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $Field = new Field('Field');
        $this->assertInstanceOf(Field::class, $Field);
    }
}
