<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\JsonFunction;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonArray as InnerJsonArray;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonArray;

/**
 * 测试JsonArray函数
 *
 * @internal
 */
#[CoversClass(JsonArray::class)]
final class JsonArrayTest extends TestCase
{
    /**
     * 测试JsonArray函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $JsonArray = new JsonArray('JsonArray');
        $inner = $JsonArray->getInner('JsonArray');

        $this->assertInstanceOf(InnerJsonArray::class, $inner);
    }

    /**
     * 测试JsonArray函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new JsonArray('JsonArray');
        $inner = $function->getInner('JsonArray');

        $this->assertInstanceOf(InnerJsonArray::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('JsonArray');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $JsonArray = new JsonArray('JsonArray');
        $this->assertInstanceOf(JsonArray::class, $JsonArray);
    }
}
