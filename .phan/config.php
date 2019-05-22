<?php

use Phan\Issue;

/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 */
return [
    // Supported values: `'5.6'`, `'7.0'`, `'7.1'`, `'7.2'`, `'7.3'`, `null`.
    // If this is set to `null`,
    // then Phan assumes the PHP version which is closest to the minor version
    // of the php executable used to execute Phan.
    //
    // Note that the **only** effect of choosing `'5.6'` is to infer
    // that functions removed in php 7.0 exist.
    // (See `backward_compatibility_checks` for additional options)
    // TODO: Set this.
    'target_php_version' => 7.0,

    // Backwards Compatibility Checking. This is slow
    // and expensive, but you should consider running
    // it before upgrading your version of PHP to a
    // new version that has backward compatibility
    // breaks.
    //
    // If you are migrating from PHP 5 to PHP 7,
    // you should also look into using
    // [php7cc (no longer maintained)](https://github.com/sstalle/php7cc)
    // and [php7mar](https://github.com/Alexia/php7mar),
    // which have different backwards compatibility checks.
    'backward_compatibility_checks' => false,

    // Set to true in order to attempt to detect unused variables.
    // `dead_code_detection` will also enable unused variable detection.
    //
    // This has a few known false positives, e.g. for loops or branches.
    'unused_variable_detection' => false,

    // If true, this runs a quick version of checks that takes less
    // time at the cost of not running as thorough
    // of an analysis. You should consider setting this
    // to true only when you wish you had more **undiagnosed** issues
    // to fix in your code base.
    //
    // In quick-mode the scanner doesn't rescan a function
    // or a method's code block every time a call is seen.
    // This means that the problem here won't be detected:
    //
    // ```php
    // <?php
    // function test($arg):int {
    //     return $arg;
    // }
    // test("abc");
    // ```
    //
    // This would normally generate:
    //
    // ```
    // test.php:3 PhanTypeMismatchReturn Returning type string but test() is declared to return int
    // ```
    //
    // The initial scan of the function's code block has no
    // type information for `$arg`. It isn't until we see
    // the call and rescan `test()`'s code block that we can
    // detect that it is actually returning the passed in
    // `string` instead of an `int` as declared.
    'quick_mode' => false,

    // The minimum severity level to report on. This can be
    // set to `Issue::SEVERITY_LOW`, `Issue::SEVERITY_NORMAL` or
    // `Issue::SEVERITY_CRITICAL`. Setting it to only
    // critical issues is a good place to start on a big
    // sloppy mature code base.
    'minimum_severity' => Issue::SEVERITY_LOW,

    // A list of plugin files to execute.
    //
    // Plugins which are bundled with Phan can be added here by providing their name (e.g. `'AlwaysReturnPlugin'`)
    //
    // Documentation about available bundled plugins can be found [here](https://github.com/phan/phan/tree/master/.phan/plugins).
    //
    // Alternately, you can pass in the full path to a PHP file with the plugin's implementation (e.g. `'vendor/phan/phan/.phan/plugins/AlwaysReturnPlugin.php'`)
    'plugins' => [
        'AlwaysReturnPlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
    //    'DuplicateExpressionPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
        'SleepCheckerPlugin',
        'UnreachableCodePlugin',
        'UseReturnValuePlugin',
    ],

    // A list of directories that should be parsed for class and
    // method information. After excluding the directories
    // defined in exclude_analysis_directory_list, the remaining
    // files will be statically analyzed for errors.
    //
    // Thus, both first-party and third-party code being used by
    // your application should be included in this list.
    'directory_list' => [
        'src',
        'bin',
        'vendor',
    ],

    // A regex used to match every file name that you want to
    // exclude from parsing. Actual value will exclude every
    // "test", "tests", "Test" and "Tests" folders found in
    // "vendor/" directory.
    'exclude_file_regex' => '@^vendor/.*/(tests?|Tests?)/@',

    // A directory list that defines files that will be excluded
    // from static analysis, but whose class and method
    // information should be included.
    //
    // Generally, you'll want to include the directories for
    // third-party code (such as "vendor/") in this list.
    //
    // n.b.: If you'd like to parse but not analyze 3rd
    //       party code, directories containing that code
    //       should be added to both the `directory_list`
    //       and `exclude_analysis_directory_list` arrays.
    'exclude_analysis_directory_list' => [
        'vendor/'
    ],
    
    // A list of individual files to include in analysis
    // with a path relative to the root directory of the
    // project.
    'file_list' => [
        'bin/php-legal-licenses',
    ],
];
