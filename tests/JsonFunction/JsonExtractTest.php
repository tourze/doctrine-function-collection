<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\JsonFunction;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonExtract as InnerJsonExtract;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonExtract;

/**
 * 测试JsonExtract函数
 *
 * @internal
 */
#[CoversClass(JsonExtract::class)]
final class JsonExtractTest extends TestCase
{
    /**
     * 测试JsonExtract函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $JsonExtract = new JsonExtract('JsonExtract');
        $inner = $JsonExtract->getInner('JsonExtract');

        $this->assertInstanceOf(InnerJsonExtract::class, $inner);
    }

    /**
     * 测试JsonExtract函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new JsonExtract('JsonExtract');
        $inner = $function->getInner('JsonExtract');

        $this->assertInstanceOf(InnerJsonExtract::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('JsonExtract');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $JsonExtract = new JsonExtract('JsonExtract');
        $this->assertInstanceOf(JsonExtract::class, $JsonExtract);
    }
}
