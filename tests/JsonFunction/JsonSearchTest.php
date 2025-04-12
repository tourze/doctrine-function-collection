<?php

namespace Tourze\DoctrineFunctionCollection\Tests\JsonFunction;

use PHPUnit\Framework\TestCase;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonSearch as InnerJsonSearch;
use Tourze\DoctrineFunctionCollection\JsonFunction\JsonSearch;

/**
 * 测试JsonSearch函数
 */
class JsonSearchTest extends TestCase
{
    /**
     * 测试JsonSearch函数返回正确的内部函数
     */
    public function testGetInner(): void
    {
        $JsonSearch = new JsonSearch('JsonSearch');
        $inner = $JsonSearch->getInner('JsonSearch');

        $this->assertInstanceOf(InnerJsonSearch::class, $inner);
    }

    /**
     * 测试JsonSearch函数能通过getInner方法获取到正确的内部函数
     */
    public function testGetInnerReturnsCorrectFunction(): void
    {
        $function = new JsonSearch('JsonSearch');
        $inner = $function->getInner('JsonSearch');

        $this->assertInstanceOf(InnerJsonSearch::class, $inner);

        // 验证实例是新创建的
        $inner2 = $function->getInner('JsonSearch');
        $this->assertNotSame($inner, $inner2, '每次调用getInner应该返回新的实例');
    }

    /**
     * 测试函数能否被正确初始化
     */
    public function testCanBeInitialized(): void
    {
        $JsonSearch = new JsonSearch('JsonSearch');
        $this->assertInstanceOf(JsonSearch::class, $JsonSearch);
    }
}
