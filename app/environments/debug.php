<?php

/**
 * Debug constants.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.20
 */

$opts = array_merge([
    // Scripts and CSS debug
    'concatenate_scripts' => false,
    'compress_scripts'    => false,
    'compress_css'        => false,
    // Turn off WSOD Protection and don't send email notification
    'wp_sandbox_scraping' => true,
    // Special Olympus error level
    'error_level'         => 100,
], isset($config['options']['debug']) ? $config['options']['debug'] : []);

/**
 * Define constants
 */

// Debug
if (!is_array($config['debug']) && false === (bool) $config['debug']) {
    // Production environment
    define('SAVEQUERIES', false);
    define('SCRIPT_DEBUG', false);
    define('WP_DEBUG_DISPLAY', false);
    define('WP_DEBUG_LOG', false);
    define('WP_DEBUG', false);

    // Scripts and CSS debug
    define('CONCATENATE_SCRIPTS', true);
    define('COMPRESS_SCRIPTS', true);
    define('COMPRESS_CSS', true);

    // Special Olympus error level
    define('ERROR_LEVEL', 500);
} else {
    $display = isset($config['debug']['wp_debug_display']) ? (bool) $config['debug']['wp_debug_display'] : true;
    $logfile = isset($config['debug']['wp_debug_log']) ? (bool) $config['debug']['wp_debug_log'] : true;

    // Development environment
    define('SAVEQUERIES', isset($config['debug']['savequeries']) ? (bool) $config['debug']['savequeries'] : true);
    define('SCRIPT_DEBUG', isset($config['debug']['script_debug']) ? (bool) $config['debug']['script_debug'] : true);
    define('WP_DEBUG_DISPLAY', $display);
    define('WP_DEBUG_LOG', $logfile ? ERRORPATH : true);
    define('WP_DEBUG', isset($config['debug']['wp_debug']) ? (bool) $config['debug']['wp_debug'] : true);

    // Scripts and CSS debug
    define('CONCATENATE_SCRIPTS', (bool) $opts['concatenate_scripts']);
    define('COMPRESS_SCRIPTS', (bool) $opts['compress_scripts']);
    define('COMPRESS_CSS', (bool) $opts['compress_css']);

    // Special Olympus error level
    define('ERROR_LEVEL', (int) $opts['error_level']);
}

// Turn off WSOD Protection and don't send email notification
define('WP_SANDBOX_SCRAPING', (bool) $opts['wp_sandbox_scraping']);

// Free memory
unset($opts);
