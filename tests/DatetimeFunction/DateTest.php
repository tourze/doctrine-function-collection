<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\ORM\Query\SqlWalker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineFunctionCollection\DatetimeFunction\Date;

/**
 * @internal
 */
#[CoversClass(Date::class)]
final class DateTest extends TestCase
{
    public function testGetInnerWithDefaultPlatform(): void
    {
        $dateFunction = new Date('DATE');
        $inner = $dateFunction->getInner('DATE');

        $this->assertInstanceOf(\DoctrineExtensions\Query\Mysql\Date::class, $inner);
    }

    public function testGetInnerWithSQLitePlatform(): void
    {
        $dateFunction = new Date('DATE');

        // Use reflection to set the private platformClass property
        $reflection = new \ReflectionClass($dateFunction);
        $property = $reflection->getProperty('platformClass');
        $property->setAccessible(true);
        $property->setValue($dateFunction, SQLitePlatform::class);

        $inner = $dateFunction->getInner('DATE');

        $this->assertInstanceOf(\DoctrineExtensions\Query\Sqlite\Date::class, $inner);
    }

    public function testGetInnerWithPostgreSQLPlatform(): void
    {
        $dateFunction = new Date('DATE');

        // Use reflection to set the private platformClass property
        $reflection = new \ReflectionClass($dateFunction);
        $property = $reflection->getProperty('platformClass');
        $property->setAccessible(true);
        $property->setValue($dateFunction, PostgreSQLPlatform::class);

        $inner = $dateFunction->getInner('DATE');

        $this->assertInstanceOf(\DoctrineExtensions\Query\Postgresql\Date::class, $inner);
    }

    public function testGetInnerWithMySQLPlatform(): void
    {
        $dateFunction = new Date('DATE');

        // Use reflection to set the private platformClass property
        $reflection = new \ReflectionClass($dateFunction);
        $property = $reflection->getProperty('platformClass');
        $property->setAccessible(true);
        $property->setValue($dateFunction, AbstractMySQLPlatform::class);

        $inner = $dateFunction->getInner('DATE');

        $this->assertInstanceOf(\DoctrineExtensions\Query\Mysql\Date::class, $inner);
    }

    public function testParseInheritsFromChainFunction(): void
    {
        $dateFunction = new Date('DATE');

        $reflection = new \ReflectionClass($dateFunction);
        $parseMethod = $reflection->getMethod('parse');

        $this->assertTrue($parseMethod->isPublic());
        $this->assertEquals('parse', $parseMethod->getName());
        $this->assertEquals(Date::class, $parseMethod->getDeclaringClass()->getName());
    }

    public function testGetSqlDetectsPlatformCorrectly(): void
    {
        $dateFunction = new Date('DATE');

        /*
         * 使用简单的测试类替换Mock以符合PHPStan Level 8规则：
         * 避免继承复杂的Doctrine类，直接创建具有必要方法的对象
         * 这样可以避免构造函数参数匹配和父类调用的复杂性
         */
        $sqlitePlatform = new SQLitePlatform();

        // Connection匿名类，继承真正的Connection来满足类型检查
        // @phpstan-ignore-next-line constructor.missingParentCall,parameter.missing,method.childParameterType
        $connection = new class($sqlitePlatform) extends Connection {
            private SQLitePlatform $mockPlatform;

            // @phpstan-ignore-next-line constructor.missingParentCall,parameter.missing,method.childParameterType
            public function __construct(SQLitePlatform $platform)
            {
                $this->mockPlatform = $platform;
                // 不调用父类构造函数，避免复杂的依赖注入
            }

            public function getDatabasePlatform(): AbstractPlatform
            {
                return $this->mockPlatform;
            }
        };

        // SqlWalker匿名类，继承真正的SqlWalker来满足类型检查
        // @phpstan-ignore-next-line constructor.missingParentCall,parameter.missing,method.childParameterType
        $sqlWalker = new class($connection) extends SqlWalker {
            private Connection $mockConnection;

            // @phpstan-ignore-next-line constructor.missingParentCall,parameter.missing,method.childParameterType
            public function __construct(Connection $connection)
            {
                $this->mockConnection = $connection;
                // 不调用父类构造函数，避免复杂的依赖注入
            }

            public function getConnection(): Connection
            {
                return $this->mockConnection;
            }
        };

        // 先验证我们的测试对象是否正确设置
        $this->assertInstanceOf(SQLitePlatform::class, $sqlitePlatform);
        $this->assertInstanceOf(SQLitePlatform::class, $connection->getDatabasePlatform());
        $this->assertSame($sqlitePlatform, $connection->getDatabasePlatform());
        $this->assertSame($connection, $sqlWalker->getConnection());

        // 直接调用 determinePlatformClass 方法来测试平台检测
        $reflection = new \ReflectionClass($dateFunction);
        $determinePlatformMethod = $reflection->getMethod('determinePlatformClass');
        $determinePlatformMethod->setAccessible(true);

        // 调用平台检测方法
        $determinePlatformMethod->invoke($dateFunction, $sqlWalker);

        // Use reflection to check the platformClass was set correctly
        $reflection = new \ReflectionClass($dateFunction);
        $property = $reflection->getProperty('platformClass');
        $property->setAccessible(true);

        $actualValue = $property->getValue($dateFunction);
        $this->assertEquals(
            SQLitePlatform::class,
            $actualValue,
            sprintf('Expected platformClass to be %s but got %s', SQLitePlatform::class, $actualValue ?? 'null')
        );
    }
}
