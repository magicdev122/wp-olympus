<?php

/**
 * Register the composer autoloader.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.1
 */

/**
 * Register the composer autoloader.
 */
if (!file_exists($autoload = VENDORPATH.'autoload.php')) {
    $ctn = 'Please use <code>curl -s http://getcomposer.org/installer | php</code> and';
    $ctn .= ' <code>php composer.phar install</code> command lines from your project folder.';

    displayError('Unable to find composer autoloader.', $ctn, 'File not found');
}

$loader = include_once $autoload;

/**
 * Include the compiled class file.
 *
 * To dramatically increase your application's performance, you may use a
 * compiled class file which contains all of the classes commonly used
 * by a request.
 */
if (file_exists($compiled = CACHEPATH.'compiled.php')) {
    include_once $compiled;
}

/**
 * Return autoload.
 */
return $loader;
