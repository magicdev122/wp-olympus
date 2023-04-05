<?php

/**
 * Define all usefull constants.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.20
 */

$path = realpath(dirname(dirname(__FILE__)));

/**
 * Global constants.
 */

// Directory separator.
defined('S')             || define('S', DIRECTORY_SEPARATOR);
// Paths.
defined('APPPATH')       || define('APPPATH', $path.S.'app'.S);
defined('CACHEPATH')     || define('CACHEPATH', APPPATH.'cache'.S);
defined('VENDORPATH')    || define('VENDORPATH', $path.S.'vendor'.S);
defined('WEBPATH')       || define('WEBPATH', $path.S.'web'.S);
// Web contents paths.
defined('DISTPATH')      || define('DISTPATH', WEBPATH.'resources'.S.'dist'.S);
// Error log.
defined('ERRORPATH')     || define('ERRORPATH', APPPATH.'logs'.S.'errors.log');

/**
 * Folder names constants.
 */

defined('WORDPRESSDIR')  || define('WORDPRESSDIR', 'cms');
defined('WPADMINDIR')    || define('WPADMINDIR', 'wp-admin');
defined('STATICSDIR')    || define('STATICSDIR', 'statics');
defined('MUPLUGINSDIR')  || define('MUPLUGINSDIR', 'mu-plugins');
defined('PLUGINSDIR')    || define('PLUGINSDIR', 'plugins');
defined('THEMESDIR')     || define('THEMESDIR', 'themes');

/**
 * Famous WordPress ABSPATH constant.
 */

defined('ABSPATH')       || define('ABSPATH', WEBPATH.WORDPRESSDIR.S);
