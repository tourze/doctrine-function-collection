<?php

namespace Tourze\DoctrineFunctionCollection\StringFunction;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Tourze\DoctrineFunctionCollection\ChainFunction;

class Field extends ChainFunction
{
    public function getInner(string $name): FunctionNode
    {
        return new \DoctrineExtensions\Query\Mysql\Field($name);
    }
}
