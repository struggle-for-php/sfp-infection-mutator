<?php

declare(strict_types=1);

namespace Sfp\Infection\Mutator\Unwrap;

use Generator;
use Infection\Mutator\Unwrap\AbstractUnwrapMutator;
use PhpParser\Node;

final class UnwrapStrReplace extends AbstractUnwrapMutator
{
    protected function getFunctionName() : string
    {
        return 'str_replace';
    }

    protected function getParameterIndexes(Node $node) : Generator
    {
        yield 2;
    }
}
