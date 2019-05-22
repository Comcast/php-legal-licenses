<?php

namespace Tests\Comcast\PhpLegalLicenses\Console;

class Intercept extends \php_user_filter
{
    public $filtername = 'intercept';

    public static $cache = '';

    public function filter($in, $out, &$consumed, $closing)
    {
        die('test in intercept');
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$cache .= $bucket->data;
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_FEED_ME;
    }
}
