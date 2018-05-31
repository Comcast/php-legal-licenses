<?php

namespace Comcast\PhpLegalLicenses\Console;

use RuntimeException;
use Symfony\Component\Console\Command\Command;

class DependencyLicenseCommand extends Command
{
    /**
     * Generates a list of dependencies from a project's composer.lock file.
     *
     * @return array
     */
    protected function getDependencyList()
    {
        $this->verifyComposerLockFilePresent();
        $packages = $this->parseComposerLockFile();
        $dependencies = $packages['packages'];

        return $dependencies;
    }

    /**
     * Verify that the composer.lock file exists.
     *
     * @return void
     */
    protected function verifyComposerLockFilePresent()
    {
        if (is_file(getcwd().'/composer.lock')) {
            return;
        }

        throw new RuntimeException('Composer Lock file missing! Please run composer install and try again.');
    }

    /**
     * Parses the composer.lock file to retrieve all installed packages.
     *
     * @return array
     */
    protected function parseComposerLockFile()
    {
        $path = getcwd().'/composer.lock';
        $contents = file_get_contents($path);

        return json_decode($contents, true);
    }
}
