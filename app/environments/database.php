<?php

/**
 * Database constants and Table prefix.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.20
 */

/**
 * WordPress Database Table prefix.
 */
$table_prefix = $config['database']['prefix'];

/**
 * Define environment constants.
 */
// Database
define('DB_HOST', (string) $config['database']['host']);
define('DB_NAME', (string) $config['database']['name']);
define('DB_USER', (string) $config['database']['user']);
define('DB_PASSWORD', (string) $config['database']['pass']);
define('DB_CHARSET', (string) $config['database']['charset']);
define('DB_COLLATE', (string) $config['database']['collate']);
