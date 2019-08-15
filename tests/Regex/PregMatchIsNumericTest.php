<?php

declare(strict_types=1);

namespace SfpTest\Infection\Mutator\Regex;

use Exception;
use Generator;
use Infection\Mutator\Util\Mutator;
use Infection\Mutator\Util\MutatorConfig;
use Infection\Tests\Mutator\AbstractMutatorTestCase;
use Sfp\Infection\Mutator\Regex\PregMatchIsNumeric;

final class PregMatchIsNumericTest extends AbstractMutatorTestCase
{
    /**
     * @dataProvider providesMutatorCases
     * @throws Exception
     */
    public function test_mutator(string $input, ?string $output = null) : void
    {
        $this->doTest($input, $output);
    }

    protected function getMutator(array $settings = []) : Mutator
    {
        return new PregMatchIsNumeric(new MutatorConfig($settings));
    }

    public function providesMutatorCases() : Generator
    {
        yield 'It mutates ' => [
            <<<'PHP'
<?php

preg_match('/\A[0-9]+\z/', '-1.23');
PHP,
            <<<'PHP'
<?php

is_numeric('-1.23');
PHP,
        ];
    }
}
