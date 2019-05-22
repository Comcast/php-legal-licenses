<?php

namespace Comcast\PhpLegalLicenses\Managers;

use InvalidArgumentException;
use Composer\Package\Locker;

class DependencyManager
{
    protected $json_path;

    protected $lock_path;

    protected $json_content;

    protected $lock_content;

    public function __construct($json_path, $lock_path)
    {
        $this->json_path = $json_path;
        $this->lock_path = $lock_path;

        $this->parse();
    }

    public function parse()
    {
        $this->verifyComposerFilesPresent();

        $json_fp = fopen($this->json_path, 'r');
        $lock_fp = fopen($this->lock_path, 'r');
        $this->json_content = fread($json_fp, filesize($this->json_path));
        $this->lock_content = json_decode(fread($lock_fp, filesize($this->lock_path)), true);

        fclose($json_fp);
        fclose($lock_fp);

        $json_hash = Locker::getContentHash($this->json_content);

        if ($json_hash !== $this->lock_content['content-hash']) {
            throw new \InvalidArgumentException('composer.json and composer.lock are out of sync. Run `composer update` to re-generate composer.lock and try again.');
        }
    }

    public function getDependencies()
    {
        return $this->lock_content['packages'];
    }

    /**
     * Verify that the composer.lock file exists.
     *
     * @throws InvalidArgumentException
     */
    protected function verifyComposerFilesPresent()
    {
        if (!is_file($this->json_path) || !is_file($this->lock_path)) {
            throw new \InvalidArgumentException('Couldn\'t find composer files. Please run in root project directory and ensure you\'ve run `composer install` or `compser update`.');
        }
    }
}
