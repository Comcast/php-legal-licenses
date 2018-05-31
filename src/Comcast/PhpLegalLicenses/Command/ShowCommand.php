<?php

namespace Comcast\PhpLegalLicenses\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends DependencyLicenseCommand
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
        ->setName('show')
        ->setDescription('Show licenses used by project dependencies.');
    }

    /**
     * Execute the command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dependencies = $this->getDependencyList();
        $this->outputDependencyLicenses($dependencies, $output);
    }

    /**
     * Generates Licenses list using packages retrieved from composer.lock file.
     *
     * @param array $dependencies
     *
     * @return void
     */
    protected function outputDependencyLicenses($dependencies, $output)
    {
        foreach ($dependencies as $dependency) {
            $text = $this->getTextForDependency($dependency);
            $output->writeln($text);
        }
    }

    /**
     * Retrieves text containing version and license information for the specified dependency.
     *
     * @param array $dependency
     *
     * @return string
     */
    protected function getTextForDependency($dependency)
    {
        $name = $dependency['name'];
        $version = $dependency['version'];
        $licenseNames = isset($dependency['license']) ? implode(', ', $dependency['license']) : 'Not configured.';

        return $this->generateDependencyText($name, $version, $licenseNames);
    }

    /**
     * Generate formatted line detailing the version and license information for a particular dependency.
     *
     * @param string $name
     * @param string $version
     * @param string $licenceNames
     *
     * @return string
     */
    protected function generateDependencyText($name, $version, $licenseNames)
    {
        return "$name@$version [$licenseNames]";
    }
}
