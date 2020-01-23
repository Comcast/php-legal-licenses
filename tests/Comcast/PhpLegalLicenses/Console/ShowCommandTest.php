<?php

namespace Tests\Comcast\PhpLegalLicenses\Console;

use LogicException;
use RuntimeException;
use PHPUnit\Framework\TestCase;
use Comcast\PhpLegalLicenses\Console\ShowCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class ShowCommandTest extends TestCase
{
    /**
     * The path to the composer.json stub used in tests.
     *
     * @var string
     */
    protected $composerMockPath = __DIR__.'/../../../stubs/composer.lock';

    protected $showOutputPath = __DIR__.'/../../../stubs/show.out';

    /**
     * ArgvInput.
     *
     * @var ArgvInput
     */
    protected $input;

    /**
     * ConsoleOutput.
     *
     * @var ConsoleOutput
     */
    protected $output;

    public static function setUpBeforeClass(): void
    {
        if (!file_exists(getcwd().'/composer.lock')) {
            throw new LogicException('Tests must be run after composer install/update.');
        }
    }

    protected function setUp(): void
    {
        if (null === $this->output) {
            $this->output = new ConsoleOutput();
        }

        if (null === $this->input) {
            $this->input = new ArgvInput();
        }
    }

    protected function tearDown(): void
    {
        if (file_exists(getcwd().'/composer.lock.bak')) {
            rename(getcwd().'/composer.lock.bak', getcwd().'/composer.lock');
        }

        $this->output = new ConsoleOutput();
        $this->input = new ArgvInput();
    }

    public function testItThrowsExceptionIfComposerLockNotFound()
    {
        $this->expectException(RuntimeException::class);

        if (!rename(getcwd().'/composer.lock', getcwd().'/composer.lock.bak')) {
            throw new LogicException('Could not backup composer.lock');
        }

        $command = new ShowCommand();
        $command->run($this->input, $this->output);
    }
}
