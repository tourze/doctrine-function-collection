<?php

namespace Tourze\DoctrineFunctionCollection\Tests;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\ChainFunction;

/**
 * 测试ChainFunction抽象类
 */
class ChainFunctionTest extends TestCase
{
    /**
     * 测试ChainFunction的基本功能
     */
    public function testChainFunctionSqlGeneration(): void
    {
        // 创建一个模拟的SqlWalker
        $sqlWalker = $this->getMockBuilder(SqlWalker::class)
            ->disableOriginalConstructor()
            ->getMock();

        // 创建ChainFunction的具体实现
        $chainFunction = new class('test_function') extends ChainFunction {
            public function getInner(string $name): FunctionNode
            {
                // 创建一个模拟的内部函数
                return new class($name) extends FunctionNode {
                    public function getSql(SqlWalker $sqlWalker): string
                    {
                        return 'MOCKED_SQL_FUNCTION()';
                    }

                    public function parse(Parser $parser): void
                    {
                        // 解析函数 - 空实现
                    }
                };
            }
        };

        // 验证SQL生成正确
        $this->assertEquals('MOCKED_SQL_FUNCTION()', $chainFunction->getSql($sqlWalker));
    }

    /**
     * 测试ChainFunction的继承结构
     */
    public function testChainFunctionInheritance(): void
    {
        // 创建ChainFunction的具体实现
        $chainFunction = new class('test_function') extends ChainFunction {
            public function getInner(string $name): FunctionNode
            {
                return new class($name) extends FunctionNode {
                    public function getSql(SqlWalker $sqlWalker): string
                    {
                        return 'TEST_FUNCTION';
                    }

                    public function parse(Parser $parser): void
                    {
                        // 空实现
                    }
                };
            }
        };

        // 验证继承关系
        $this->assertInstanceOf(ChainFunction::class, $chainFunction);
        $this->assertInstanceOf(FunctionNode::class, $chainFunction);
    }

    /**
     * 测试ChainFunction的getInner方法能被调用
     */
    public function testChainFunctionGetInner(): void
    {
        // 创建ChainFunction的具体实现
        $chainFunction = new class('test_function') extends ChainFunction {
            public function getInner(string $name): FunctionNode
            {
                return new class($name) extends FunctionNode {
                    public function getSql(SqlWalker $sqlWalker): string
                    {
                        return 'TEST_FUNCTION';
                    }

                    public function parse(Parser $parser): void
                    {
                        // 空实现
                    }
                };
            }
        };

        // 验证getInner返回FunctionNode实例
        $inner = $chainFunction->getInner('test_function');
        $this->assertInstanceOf(FunctionNode::class, $inner);
    }
}
