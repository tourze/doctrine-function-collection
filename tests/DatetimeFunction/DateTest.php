<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\Tests\DatetimeFunction;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
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

        // 使用 PHPUnit Mock 替代匿名类，避免继承复杂的 Doctrine 类
        $sqlitePlatform = new SQLitePlatform();

        // 创建 Connection Mock
        $connection = $this->createMock(Connection::class);
        $connection->method('getDatabasePlatform')->willReturn($sqlitePlatform);

        // 创建 SqlWalker Mock
        $sqlWalker = $this->createMock(SqlWalker::class);
        $sqlWalker->method('getConnection')->willReturn($connection);

        // 验证 Mock 设置正确
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
