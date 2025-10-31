<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection\StringFunction;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Tourze\DoctrineFunctionCollection\ChainFunction;

class AnyValue extends ChainFunction
{
    public function getInner(string $name): FunctionNode
    {
        return new \DoctrineExtensions\Query\Mysql\AnyValue($name);
    }
}
