<?php

declare(strict_types=1);

namespace Tourze\DoctrineFunctionCollection;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

abstract class ChainFunction extends FunctionNode
{
    protected FunctionNode $inner;

    public function __construct(mixed $name)
    {
        parent::__construct($name);
        $this->inner = $this->getInner((string) $name);
    }

    abstract public function getInner(string $name): FunctionNode;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->inner->getSql($sqlWalker);
    }

    public function parse(Parser $parser): void
    {
        $this->inner->parse($parser);
    }
}
