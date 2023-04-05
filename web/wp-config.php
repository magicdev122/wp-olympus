<?php

/**
 * File used by WordPress to list all constant options.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.1
 */

/**
 * Global constants if needed.
 */
if (!defined('APPPATH')) {
    include_once rtrim(realpath(dirname(__FILE__)), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'constants.php';
}

/**
 * Bootstrap WordPress.
 */
require_once APPPATH.'app.php';

/**
 * DO NOT add any constants in this file.
 *
 * We recommend you to exclusively add your own constants
 * in the `own.php` file instead of here, for more security.
 * Please, see the `environment.php` file for more instructions.
 */

/**
 * Sets up WordPress vars and included files.
 */
require_once ABSPATH.'wp-settings.php';
