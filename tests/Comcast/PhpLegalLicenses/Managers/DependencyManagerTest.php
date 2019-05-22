<?php

namespace Tests\Comcast\PhpLegalLicenses\Managers;

use InvalidArgumentException;
use Comcast\PhpLegalLicenses\Managers\DependencyManager;
use PHPUnit\Framework\TestCase;

class DependencyManagerTest extends TestCase
{
    public function testItLoadsComposerFiles()
    {
        $manager = new DependencyManager(__DIR__.'/../../../stubs/composer.json', __DIR__.'/../../../stubs/composer.lock');
        $this->addToAssertionCount(1);
    }

    public function testItFailsWithMissingFiles()
    {
        $this->expectException(InvalidArgumentException::class);

        $manager = new DependencyManager(__DIR__.'/composer.json', __DIR__.'/composer.lock');
    }

    public function testItFailsOnHashMismatch()
    {
        $this->expectException(InvalidArgumentException::class);

        $manager = new DependencyManager(__DIR__.'/../../../stubs/composer.json', __DIR__.'/../../../stubs/composer.lock.bad.hash');
    }

    public function testItRetrievesDependencies()
    {
        $manager = new DependencyManager(__DIR__.'/../../../stubs/composer.json.small', __DIR__.'/../../../stubs/composer.lock.small');

        $dependencies = $manager->getDependencies();

        $this->assertEquals([
            [
                'name' => 'pds/skeleton',
                'version' => '1.0.0',
                'source' => [
                    'type' => 'git',
                    'url' => 'https://github.com/php-pds/skeleton.git',
                    'reference' => '95e476e5d629eadacbd721c5a9553e537514a231',
                ],
                'dist' => [
                    'type' => 'zip',
                    'url' => 'https://api.github.com/repos/php-pds/skeleton/zipball/95e476e5d629eadacbd721c5a9553e537514a231',
                    'reference' => '95e476e5d629eadacbd721c5a9553e537514a231',
                    'shasum' => '',
                ],
                'bin' => [
                    'bin/pds-skeleton',
                ],
                'type' => 'standard',
                'autoload' => [
                    'psr-4' => [
                        'Pds\\Skeleton\\' => 'src/',
                    ],
                ],
                'notification-url' => 'https://packagist.org/downloads/',
                'license' => [
                    'CC-BY-SA-4.0',
                ],
                'description' => 'Standard for PHP package skeletons.',
                'homepage' => 'https://github.com/php-pds/skeleton',
                'time' => '2017-01-25T23:30:41+00:00',
            ],
        ], $dependencies);
    }
}
