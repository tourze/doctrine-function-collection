<?php

/**
 * 用于生成Doctrine Function Collection单元测试的脚本
 */

// 日期时间函数
$datetimeFunctions = [
    'Hour',
    'Minute',
    'Month',
    'Week',
    'WeekDay',
    'Year',
];

// 字符串函数
$stringFunctions = [
    'AnyValue',
    'DateDiff',
    'Field',
    'FindInSet',
    'Rand',
];

// JSON函数 - 根据命名空间分类
$jsonFunctions = [
    // DoctrineExtensions命名空间
    'JsonLength' => '\DoctrineExtensions\Query\Mysql\JsonLength',
    // Scienta命名空间
    'JsonArray' => '\Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonArray',
    'JsonExtract' => '\Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonExtract',
    'JsonContains' => '\Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonContains',
    'JsonSearch' => '\Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonSearch',
];

/**
 * 生成DatetimeFunction测试模板
 * @param string $functionName
 */
function generateDatetimeFunctionTest(string $functionName): string
{
    return <<<PHP
        <?php

        namespace Tourze\\DoctrineFunctionCollection\\Tests\\DatetimeFunction;

        use Symfony\\Bundle\\FrameworkBundle\\Test\\WebTestCase;
        use Doctrine\\ORM\\Query\\SqlWalker;
        use DoctrineExtensions\\Query\\Mysql\\{$functionName} as Mysql{$functionName};
        use PHPUnit\\Framework\\TestCase;
        use ReflectionMethod;
        use Tourze\\DoctrineFunctionCollection\\DatetimeFunction\\{$functionName};

        /**
         * 测试{$functionName}函数
         */
        class {$functionName}Test extends TestCase
        {
            /**
             * 测试{$functionName}函数返回正确的内部函数
             */
            public function testGetInner(): void
            {
                \${$functionName} = new {$functionName}('{$functionName}');
                \$inner = \${$functionName}->getInner('{$functionName}');
                
                \$this->assertInstanceOf(Mysql{$functionName}::class, \$inner);
            }
            
            /**
             * 测试{$functionName}函数能通过getInner方法获取到正确的内部函数
             */
            public function testGetInnerReturnsCorrectFunction(): void
            {
                \$function = new {$functionName}('{$functionName}');
                \$inner = \$function->getInner('{$functionName}');
                
                \$this->assertInstanceOf(Mysql{$functionName}::class, \$inner);
                
                // 验证实例是新创建的
                \$inner2 = \$function->getInner('{$functionName}');
                \$this->assertNotSame(\$inner, \$inner2, '每次调用getInner应该返回新的实例');
            }
            
            /**
             * 测试函数能否被正确初始化
             */
            public function testCanBeInitialized(): void
            {
                \${$functionName} = new {$functionName}('{$functionName}');
                \$this->assertInstanceOf({$functionName}::class, \${$functionName});
            }
        }
        PHP;
}

/**
 * 生成StringFunction测试模板
 * @param string $functionName
 */
function generateStringFunctionTest(string $functionName): string
{
    return <<<PHP
        <?php

        namespace Tourze\\DoctrineFunctionCollection\\Tests\\StringFunction;

        use Tourze\\DoctrineFunctionCollection\\StringFunction\\{$functionName};

        /**
         * 测试{$functionName}函数
         */
        class {$functionName}Test extends TestCase
        {
            /**
             * 测试{$functionName}函数返回正确的内部函数
             */
            public function testGetInner(): void
            {
                \${$functionName} = new {$functionName}('{$functionName}');
                \$inner = \${$functionName}->getInner('{$functionName}');
                
                \$this->assertInstanceOf(Mysql{$functionName}::class, \$inner);
            }
            
            /**
             * 测试{$functionName}函数能通过getInner方法获取到正确的内部函数
             */
            public function testGetInnerReturnsCorrectFunction(): void
            {
                \$function = new {$functionName}('{$functionName}');
                \$inner = \$function->getInner('{$functionName}');
                
                \$this->assertInstanceOf(Mysql{$functionName}::class, \$inner);
                
                // 验证实例是新创建的
                \$inner2 = \$function->getInner('{$functionName}');
                \$this->assertNotSame(\$inner, \$inner2, '每次调用getInner应该返回新的实例');
            }
            
            /**
             * 测试函数能否被正确初始化
             */
            public function testCanBeInitialized(): void
            {
                \${$functionName} = new {$functionName}('{$functionName}');
                \$this->assertInstanceOf({$functionName}::class, \${$functionName});
            }
        }
        PHP;
}

/**
 * 生成JsonFunction测试模板
 * @param string $functionName
 * @param string $innerClass
 */
function generateJsonFunctionTest(string $functionName, string $innerClass): string
{
    // 从完整类名中提取简短类名
    $lastPos = strrpos($innerClass, '\\');
    $innerClassName = substr($innerClass, false !== $lastPos ? $lastPos + 1 : 0);
    // 提取命名空间
    $namespacePath = false !== $lastPos ? substr($innerClass, 0, $lastPos) : $innerClass;

    return <<<PHP
        <?php

        namespace Tourze\\DoctrineFunctionCollection\\Tests\\JsonFunction;

        use {$namespacePath}\\{$innerClassName} as Inner{$functionName};
        use Tourze\\DoctrineFunctionCollection\\JsonFunction\\{$functionName};

        /**
         * 测试{$functionName}函数
         */
        class {$functionName}Test extends TestCase
        {
            /**
             * 测试{$functionName}函数返回正确的内部函数
             */
            public function testGetInner(): void
            {
                \${$functionName} = new {$functionName}('{$functionName}');
                \$inner = \${$functionName}->getInner('{$functionName}');
                
                \$this->assertInstanceOf(Inner{$functionName}::class, \$inner);
            }
            
            /**
             * 测试{$functionName}函数能通过getInner方法获取到正确的内部函数
             */
            public function testGetInnerReturnsCorrectFunction(): void
            {
                \$function = new {$functionName}('{$functionName}');
                \$inner = \$function->getInner('{$functionName}');
                
                \$this->assertInstanceOf(Inner{$functionName}::class, \$inner);
                
                // 验证实例是新创建的
                \$inner2 = \$function->getInner('{$functionName}');
                \$this->assertNotSame(\$inner, \$inner2, '每次调用getInner应该返回新的实例');
            }
            
            /**
             * 测试函数能否被正确初始化
             */
            public function testCanBeInitialized(): void
            {
                \${$functionName} = new {$functionName}('{$functionName}');
                \$this->assertInstanceOf({$functionName}::class, \${$functionName});
            }
        }
        PHP;
}

// 生成DatetimeFunction测试
foreach ($datetimeFunctions as $functionName) {
    $testContent = generateDatetimeFunctionTest($functionName);
    $filepath = __DIR__ . "/DatetimeFunction/{$functionName}Test.php";
    file_put_contents($filepath, $testContent);
    echo "Generated test for {$functionName}\n";
}

// 生成StringFunction测试
foreach ($stringFunctions as $functionName) {
    $testContent = generateStringFunctionTest($functionName);
    $filepath = __DIR__ . "/StringFunction/{$functionName}Test.php";
    file_put_contents($filepath, $testContent);
    echo "Generated test for {$functionName}\n";
}

// 生成JsonFunction测试
foreach ($jsonFunctions as $functionName => $innerClass) {
    $testContent = generateJsonFunctionTest($functionName, $innerClass);
    $filepath = __DIR__ . "/JsonFunction/{$functionName}Test.php";
    file_put_contents($filepath, $testContent);
    echo "Generated test for {$functionName}\n";
}

echo "All tests generated successfully!\n";
