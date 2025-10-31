<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\JsonFunction;

use DoctrineExtensions\Query\Mysql\JsonContains as InnerJsonContains;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonContains;

/**
 * 测试JsonContains函数
 *
 * @internal
 */
#[CoversClass(JsonContains::class)]
final class JsonContainsTest extends TestCase
{
    /**
     * 测试JsonContains函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $jsonContains = new JsonContains('JSON_CONTAINS');
        $inner = $jsonContains->getInner('JSON_CONTAINS');

        $this->assertInstanceOf(InnerJsonContains::class, $inner);
    }

    /**
     * 测试JsonContains函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new JsonContains('JSON_CONTAINS');
        $inner = $function->getInner('JSON_CONTAINS');

        $this->assertInstanceOf(InnerJsonContains::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('JSON_CONTAINS');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $jsonContains = new JsonContains('JSON_CONTAINS');
        $this->assertInstanceOf(JsonContains::class, $jsonContains);
    }
}
