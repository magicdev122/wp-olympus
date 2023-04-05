<?php

/**
 * Autoload vendors and set all defined WordPress constants.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.2
 */

// Return array of environment data
if (!file_exists($env = APPPATH.'config'.S.'env.php')) {
    $ctn  = 'Please define your environments properly in <code>'.basename(APPPATH).S.'config'.S.'env.php</code> file.';
    $ctn .= '<br/>You can find an example in the <code>'.basename(APPPATH).S.'config'.S.'env.php.dist</code> file.';

    displayError('Unable to load your environment data.', $ctn, 'File not found');
}

// Load all environments
$environments = include_once $env;
$defaults = include_once APPPATH.'config'.S.'env.php.dist';

// Special case: works on `home` and `siteurl`
$environments['wordpress']['home']    = rtrim($environments['wordpress']['home'], S);
$environments['wordpress']['siteurl'] = rtrim($environments['wordpress']['home'].S.WORDPRESSDIR, S);

/**
 * Define optional constants.
 */
if (file_exists($opts = APPPATH.'config'.S.'opts.php')) {
    // Load all options
    $options = include_once $opts;

    // Merge environments and options
    $environments = array_merge($environments, ['options' => $options]);

    // Free memory
    unset($options);
    unset($opts);
}

/**
 * Retrieve all configs / optionals and merge them with defaults
 */
$config = array_merge($defaults, $environments);

/**
 * Include files containing constants definitions.
 */
// Database constants and Table prefix
include_once APPPATH.'environments'.S.'database.php';

// Site URL, Home URL, SSL and Directories
include_once APPPATH.'environments'.S.'website.php';

// Theme editor, Revisions, Trash days, Updater and Cron
include_once APPPATH.'environments'.S.'configuration.php';

// Cache
include_once APPPATH.'environments'.S.'cache.php';

// Multisite options
include_once APPPATH.'environments'.S.'multisite.php';

// Cookies names and definitions
include_once APPPATH.'environments'.S.'cookies.php';

// Debug
include_once APPPATH.'environments'.S.'debug.php';

// Free memory
unset($config);
unset($defaults);
unset($env);
unset($environments);

/**
 * Define salt constants.
 */
if (!file_exists($salt = APPPATH.'config'.S.'salt.php')) {
    $ctn  = 'Please define your constants properly in <code>'.basename(APPPATH).S.'config'.S.'salt.php</code> file.';
    $ctn .= '<br/>You can find an example in the <code>'.basename(APPPATH).S.'config'.S.'salt.php.dist</code> file.';

    displayError('Unable to load your salt data.', $ctn, 'File not found');
}

require_once $salt;

/**
 * Define your own constants.
 *
 * We recommend you to exclusively add your own constants in this
 * `app/config/own.php` file instead of `web/wp-config.php`.
 *
 * Create you `app/config/own.php` thanks to the `app/config/own.php.dist`.
 */
if (file_exists($own = APPPATH.'config'.S.'own.php')) {
    require_once $own;
}
