<?php

use Olympus\Components\Error\ErrorDebugger;

/**
 * Catches all errors.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.6
 */

/**
 * Use the ErrorDebugger to display errors in development environment only
 */
$err = ErrorDebugger::register([
    'debug' => WP_DEBUG,
    'level' => ERROR_LEVEL,
    'logs'  => dirname(__FILE__).S.'logs'.S,
    'title' => 'Olympus',
]);
