<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\JsonFunction;

use DoctrineExtensions\Query\Mysql\JsonLength as InnerJsonLength;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonLength;

/**
 * 测试JsonLength函数
 *
 * @internal
 */
#[CoversClass(JsonLength::class)]
final class JsonLengthTest extends TestCase
{
    /**
     * 测试JsonLength函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $JsonLength = new JsonLength('JsonLength');
        $inner = $JsonLength->getInner('JsonLength');

        $this->assertInstanceOf(InnerJsonLength::class, $inner);
    }

    /**
     * 测试JsonLength函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new JsonLength('JsonLength');
        $inner = $function->getInner('JsonLength');

        $this->assertInstanceOf(InnerJsonLength::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('JsonLength');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $JsonLength = new JsonLength('JsonLength');
        $this->assertInstanceOf(JsonLength::class, $JsonLength);
    }
}
