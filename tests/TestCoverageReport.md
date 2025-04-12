# Doctrine Function Collection 测试覆盖率报告

## 核心类

| 类 | 测试状态 | 备注 |
|---|---|---|
| `ChainFunction` | ✅ 已覆盖 | 测试了继承结构、SQL生成和getInner功能 |

## 日期/时间函数

| 类 | 测试状态 | 备注 |
|---|---|---|
| `Day` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Hour` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Minute` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Month` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Week` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `WeekDay` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Year` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |

## 字符串函数

| 类 | 测试状态 | 备注 |
|---|---|---|
| `AnyValue` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `DateDiff` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Field` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `FindInSet` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `IfElse` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `Rand` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |

## JSON函数

| 类 | 测试状态 | 备注 |
|---|---|---|
| `JsonArray` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `JsonContains` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `JsonExtract` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `JsonLength` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |
| `JsonSearch` | ✅ 已覆盖 | 测试了getInner和SQL生成功能 |

## 测试统计

- 总类数：19
- 已测试类数：19
- 覆盖率：100%

## 测试方法

以下是我们在测试中使用的方法:

1. **单元测试**:
   - 对每个类进行独立的单元测试
   - 使用PHPUnit断言验证结果
   - 通过反射访问继承的方法

2. **模拟对象**:
   - 使用PHPUnit的模拟框架创建依赖对象
   - 对复杂对象使用模拟替代

3. **测试用例类型**:
   - 初始化测试：验证对象可以正确实例化
   - 功能测试：测试SQL生成和内部函数访问
   - 继承测试：验证继承关系是否正确

## 运行测试

从项目根目录运行以下命令：

```bash
./vendor/bin/phpunit packages/doctrine-function-collection/tests
```
