<?php

namespace Tourze\DoctrineFunctionCollection\DatetimeFunction;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Tourze\DoctrineFunctionCollection\ChainFunction;

class WeekDay extends ChainFunction
{
    public function getInner(string $name): FunctionNode
    {
        return new \DoctrineExtensions\Query\Mysql\WeekDay($name);
    }
}
