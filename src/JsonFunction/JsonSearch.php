<?php

namespace Tourze\DoctrineFunctionCollection\JsonFunction;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Tourze\DoctrineFunctionCollection\ChainFunction;

class JsonSearch extends ChainFunction
{
    public function getInner(string $name): FunctionNode
    {
        return new \Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonSearch($name);
    }
}
