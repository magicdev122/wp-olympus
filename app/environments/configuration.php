<?php

/**
 * Configuration constants.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.20
 */

// Default options
$opts = array_merge([
    // Set memory limit
    'wp_memory_limit'      => '128M',
    'wp_max_memory_limit'  => '256M',
    // Autosave interval in seconds
    'autosave_interval'    => 60,
    // Cron lock timeout in seconds
    'wp_cron_lock_timeout' => 60,
    // Trash feature for media
    'media_trash'          => true,
    // Allow users to update core, themes or plugins
    'disallow_file_mods'   => false,
    // Allow editing images to replace the originals
    'image_edit_overwrite' => false,
    // Enforce GZIP encoding
    'enforce_gzip'         => false,
    // FS method
    'fs_method'            => false,
    'fs_chmod_dir'         => (0755 & ~ umask()),
    'fs_chmod_file'        => (0644 & ~ umask()),
    // Temp directory ~ We recommand to leave this empty
    'wp_temp_dir'          => '',
], isset($config['options']['configuration']) ? $config['options']['configuration'] : []);

/**
 * Define constants
 */

// Disable file editor in the "Theme / Plugin editor"
if (false === (bool) $config['file_edit']) {
    define('DISALLOW_FILE_EDIT', true);
}

// Fix revisions up to 10 - 0 to disable revisions, remove the line to make it infinite
if (-1 < (int) $config['wordpress']['revisions']) {
    define('WP_POST_REVISIONS', (int) $config['wordpress']['revisions']);
}

// Days for posts in trash
if (-1 < (int) $config['wordpress']['posts_in_trash']) {
    define('EMPTY_TRASH_DAYS', (int) $config['wordpress']['posts_in_trash']);
}

// Automatic updater and core upgrader
// Can be set to `true` (for all), 'beta', 'rc', 'minor', `false`
if (in_array((string) $config['wordpress']['disable_updater'], ['beta', 'rc', 'minor', '1'])) {
    define('AUTOMATIC_UPDATER_DISABLED', true);

    if (is_bool($config['wordpress']['disable_updater'])) {
        define('CORE_UPGRADE_SKIP_NEW_BUNDLED', true);
    } else {
        define('WP_AUTO_UPDATE_CORE', (string) $config['wordpress']['disable_updater']);
    }
}

// We recommand that you DO NOT use the default WordPress cron which is made to work
// for those who do not have an ssh access to their server
if (false === (bool) $config['cron']) {
    define('ALTERNATE_WP_CRON', false);
    define('DISABLE_WP_CRON', true);
}

// Set memory limit
define('WP_MEMORY_LIMIT', (string) $opts['wp_memory_limit']);
define('WP_MAX_MEMORY_LIMIT', (string) $opts['wp_max_memory_limit']);

// Autosave interval in seconds
define('AUTOSAVE_INTERVAL', (int) $opts['autosave_interval']);

// Cron lock timeout in seconds
define('WP_CRON_LOCK_TIMEOUT', (int) $opts['wp_cron_lock_timeout']);

// Trash feature for media
define('MEDIA_TRASH', (bool) $opts['media_trash']);

// Allow users to update core, themes or plugins
define('DISALLOW_FILE_MODS', (bool) $opts['disallow_file_mods']);

// Allow editing images to replace the originals
define('IMAGE_EDIT_OVERWRITE', (bool) $opts['image_edit_overwrite']);

// Enforce GZIP encoding
define('ENFORCE_GZIP', (bool) $opts['enforce_gzip']);

// FS method, only work for 'direct', 'ssh2', 'ftpext' or 'ftpsockets'
if (is_string($opts['fs_method']) && in_array($opts['fs_method'], ['direct', 'ssh2', 'ftpext', 'ftpsockets'])) {
    define('FS_METHOD', (string) $opts['fs_method']);
    define('FS_CHMOD_DIR', (int) $opts['fs_chmod_dir']);
    define('FS_CHMOD_FILE', (int) $opts['fs_chmod_file']);
}

// Set the directory files that should be downloaded to before they are moved (usually set in the PHP conf)
// Leave this empty to not override default WordPress value
if (!empty($opts['wp_temp_dir'])) {
    define('WP_TEMP_DIR', (string) $opts['wp_temp_dir']);
}


// Free memory
unset($opts);
