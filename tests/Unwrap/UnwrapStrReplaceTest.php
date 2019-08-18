<?php
/**
 * a part of this code is borrowed from Infection's UnwrapStrToLowerTest
 * Copyright (c) 2017-2019, Maks Rafalko
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace SfpTest\Infection\Mutator\Unwrap;
use Infection\Mutator\Util\Mutator;
use Infection\Mutator\Util\MutatorConfig;
use Infection\Tests\Mutator\AbstractMutatorTestCase;
use Sfp\Infection\Mutator\Unwrap\UnwrapStrReplace;

final class UnwrapStrReplaceTest extends AbstractMutatorTestCase
{
    /**
     * @dataProvider provideMutationCases
     */
    public function test_mutator($input, $expected = null): void
    {
        $this->doTest($input, $expected);
    }

    protected function getMutator(array $settings = []) : Mutator
    {
        return new UnwrapStrReplace(new MutatorConfig($settings));
    }

    public function provideMutationCases(): \Generator
    {
        yield 'It mutates correctly when provided with a string' => [
            <<<'PHP'
<?php

$a = str_replace('Afternoon', 'Evening' ,'Good Afternoon!');
PHP
            ,
            <<<'PHP'
<?php

$a = 'Good Afternoon!';
PHP
        ];

        yield 'It mutates correctly when provided with a constant' => [
            <<<'PHP'
<?php

$a = str_replace('X', 'Y', \Class_With_Const::Const);
PHP
            ,
            <<<'PHP'
<?php

$a = \Class_With_Const::Const;
PHP
        ];

        yield 'It mutates correctly when a backslash is in front of strtolower' => [
            <<<'PHP'
<?php

$a = \str_replace('Afternoon', 'Evening' ,'Good Afternoon!');
PHP
            ,
            <<<'PHP'
<?php

$a = 'Good Afternoon!';
PHP
        ];

        yield 'It mutates correctly within if statements' => [
            <<<'PHP'
<?php

$a = 'Good Afternoon!';
if (str_replace('Afternoon', 'Evening', $a) === $a) {
    return true;
}
PHP
            ,
            <<<'PHP'
<?php

$a = 'Good Afternoon!';
if ($a === $a) {
    return true;
}
PHP
        ];

        yield 'It mutates correctly when str_replace is wrongly capitalized' => [
            <<<'PHP'
<?php

$a = sTr_RepLace('Afternoon', 'Evening' ,'Good Afternoon!');
PHP
            ,
            <<<'PHP'
<?php

$a = 'Good Afternoon!';
PHP
        ];

        yield 'It mutates correctly when str_replace uses another function as input' => [
            <<<'PHP'
<?php

$a = str_replace('Afternoon', 'Evening' , $foo->bar());
PHP
            ,
            <<<'PHP'
<?php

$a = $foo->bar();
PHP
        ];

        yield 'It mutates correctly when provided with a more complex situation' => [
            <<<'PHP'
<?php

$a = str_replace('Foo', 'Bar', array_reduce($words, function (string $carry, string $item) {
    return $carry . substr($item, 0, 1);
}));
PHP
            ,
            <<<'PHP'
<?php

$a = array_reduce($words, function (string $carry, string $item) {
    return $carry . substr($item, 0, 1);
});
PHP
        ];

        yield 'It does not mutate other str* calls' => [
            <<<'PHP'
<?php

$a = str_ireplace('Afternoon', 'Evening' ,'Good Afternoon!');
PHP
        ];

        yield 'It does not mutate functions named str_replace' => [
            <<<'PHP'
<?php

function str_replace($search , $replace , $subject , int &$count = null)
{
}
PHP
        ];

        yield 'It does not break when provided with a variable function name' => [
            <<<'PHP'
<?php

$a = 'str_replace';

$b = $a('Bar', 'Baz', 'FooBar');
PHP
            ,
        ];
    }
}
