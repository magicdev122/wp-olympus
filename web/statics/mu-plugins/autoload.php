<?php

use Olympus\Components\Autoloader\MuPlugins;

/**
 * This autoloader initialize all details for Olympus Hera and Zeus.
 * It brings all necessary statics for plugins and themes.
 *
 * @category PHP
 * @package  Olympus
 * @author   Achraf Chouk <achrafchouk@gmail.com>
 * @license  https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link     https://github.com/GetOlympus/Olympus
 * @since    0.0.1
 */

/**
 * Plugin Name: Olympus Autoload
 * Plugin URI: https://github.com/GetOlympus/Olympus
 * Description: This autoloader initialize all details for Olympus bundles and brings statics for plugins and themes.
 * Version: 0.0.1
 * Author: crewstyle
 * Author URI: https://github.com/crewstyle
 * License: MIT License
 */

/**
 * Autoload all mu-plugins.
 * As the first autoloaded file, all useful constants are defined here.
 */
add_action('setup_theme', function () {
    /**
     * Template configurations.
     */

    // Current theme repertory.
    define('OL_TPL_DIR', get_template_directory());
    // Current theme URI.
    define('OL_TPL_DIR_URI', get_template_directory_uri());
    define('OL_TPL_DICTIONARY', basename(OL_TPL_DIR));


    /**
     * Blog definitions.
     */

    $name = get_bloginfo('name');
    $description = get_bloginfo('description');

    // Home URL
    define('OL_BLOG_HOME', WP_HOME);
    // WP URL
    define('OL_BLOG_WPURL', get_bloginfo('wpurl'));
    // Language
    define('OL_BLOG_LANGUAGE', get_bloginfo('language'));
    // Homepage escaped url
    define('OL_BLOG_HOME_URL_ESCAPED', esc_url(home_url('/')));
    // Author
    define('OL_BLOG_AUTHOR', get_bloginfo('author'));
    // Name
    define('OL_BLOG_NAME', $name);
    // Description
    define('OL_BLOG_DESCRIPTION', $description);
    // Escaped name
    define('OL_BLOG_NAME_ESCAPED', esc_attr($name));
    // Escaped description
    define('OL_BLOG_DESCRIPTION_ESCAPED', esc_attr($description));
    // Title
    define('OL_BLOG_TITLE', get_bloginfo('title'));
    // Charset
    define('OL_BLOG_CHARSET', get_bloginfo('charset'));
    // Pingback URL
    define('OL_BLOG_PINGBACK_URL', get_bloginfo('pingback_url'));
    // Pingback URL
    define('OL_BLOG_RSS', get_bloginfo('rss_url'));

    // Memory free
    unset($name, $description);


    /**
     * Global definitions.
     */

    // Define if we are in the admin panel or not
    defined('OL_ISADMIN')       || define('OL_ISADMIN', is_admin());
    // Define if the user is connected or not
    defined('OL_ISCONNECTED')   || define('OL_ISCONNECTED', is_user_logged_in());
    // The dist folder URI
    defined('OL_DISTURI')       || define('OL_DISTURI', OL_BLOG_HOME.'/resources/dist/');
    // AJAX NONCE value
    defined('OL_NONCE')         || define('OL_NONCE', wp_create_nonce(basename(OL_TPL_DIR).'_ajax_nonce'));


    /**
     * Class initialization.
     */

    (new MuPlugins(OL_ISADMIN))->init();
});

/**
 * Define extra constants after theme setup.
 */
add_action('after_setup_theme', function () {
    /**
     * Global definitions.
     */

    // Define if we are in customizer's preview mode or not
    defined('OL_ISPREVIEW') || define('OL_ISPREVIEW', is_customize_preview());
});

/**
 * Update theme root folder.
 */
add_filter('theme_root', function () {
    return WP_THEME_DIR;
});
add_filter('theme_root_uri', function () {
    return WP_THEME_URL;
});

/**
 * Update automatically the `own.php` configuration file.
 */
add_action('admin_footer', function () {
    $screen = get_current_screen();

    // Check network admin page or POST action
    if ('network' !== $screen->base || !$_POST) {
        return;
    }

    // Set target file and contents
    $target   = APPPATH.'config'.S.'own.php';
    $contents = '';

    // Check target file
    if (!file_exists($target)) {
        $contents = "<?php\n\n/**\n * File auto-generated.\n */\n\n";
    } else {
        $contents = file_get_contents($target);
        $contents .= "\n/**\n * Contents auto-generated for multisite.\n */\n\n";
    }

    // Check `define('MULTISITE', true);` constant definition
    if (!preg_match_all('#^\s?define\(\s?\'MULTISITE\'\s?,#msi', $contents, $matches)) {
        $contents .= "define('MULTISITE', true);\n";
    }

    // Check `define('SUBDOMAIN_INSTALL', ***);` constant definition
    if (!preg_match_all('#^\s?define\(\s?\'SUBDOMAIN_INSTALL\'\s?,#msi', $contents, $matches)) {
        global $wpdb;

        // Get value from DB
        $subdomainInstall = (bool) $wpdb->get_var('
            SELECT meta_value FROM '.$wpdb->sitemeta.' WHERE site_id = 1 AND meta_key = "subdomain_install"
        ');

        $contents .= "define('SUBDOMAIN_INSTALL', ".($subdomainInstall ? 'true' : 'false').");\n";
    }

    // Check `define('DOMAIN_CURRENT_SITE', ***);` constant definition
    if (!preg_match_all('#^\s?define\(\s?\'DOMAIN_CURRENT_SITE\'\s?,#msi', $contents, $matches)) {
        $domainCurrentSite = '\''.get_clean_basedomain().'\'';
        $contents         .= "define('DOMAIN_CURRENT_SITE', $domainCurrentSite);\n";
    }

    // Check `define('PATH_CURRENT_SITE', ***);` constant definition
    if (!preg_match_all('#^\s?define\(\s?\'PATH_CURRENT_SITE\'\s?,#msi', $contents, $matches)) {
        $pathCurrentSite = '\''.parse_url(trailingslashit(get_option('home')), PHP_URL_PATH).'\'';
        $contents       .= "define('PATH_CURRENT_SITE', $pathCurrentSite);\n";
    }

    // Check `define('SITE_ID_CURRENT_SITE', ***);` constant definition
    if (!preg_match_all('#^\s?define\(\s?\'SITE_ID_CURRENT_SITE\'\s?,#msi', $contents, $matches)) {
        $contents .= "define('SITE_ID_CURRENT_SITE', 1);\n";
    }

    // Check `define('BLOG_ID_CURRENT_SITE', ***);` constant definition
    if (!preg_match_all('#^\s?define\(\s?\'BLOG_ID_CURRENT_SITE\'\s?,#msi', $contents, $matches)) {
        $contents .= "define('BLOG_ID_CURRENT_SITE', 1);\n";
    }

    // Puts contents into target configuration file
    file_put_contents($target, $contents);
});

/**
 * Update network admin URL.
 */
add_filter('network_site_url', function ($url, $path, $scheme) {
    // Check network admin path
    if ('wp-admin/network/' !== $path || 'admin' !== $scheme) {
        return $url;
    }

    // Fix path by adding the WORDPRESSDIR constant
    $currentNetwork = get_network();
    $url = set_url_scheme('https://'.$currentNetwork->domain.'/'.WORDPRESSDIR.$currentNetwork->path, $scheme);

    return $url.ltrim($path, '/');
}, 10, 3);

/**
 * Filters reserved site names on a sub-directory Multisite installation.
 */
add_filter('subdirectory_reserved_names', function ($names) {
    return array_merge($names, [WORDPRESSDIR]);
});

/**
 * Fires once a site has been created.
 * Useful to update the `siteurl` and `home` options.
 */
add_action('wpmu_new_blog', function ($blogId, $userId, $domain, $path, $siteId, $meta) {
    // Switch the newly created blog
    switch_to_blog($blogId);

    // Get `siteurl` network option
    $siteUrl = get_option('siteurl');
    $siteUrl = rtrim($siteUrl, '/');

    // Check is HTTPS protocol is used and update siteurl if needed
    $isHttps = defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN;
    $siteUrl = $isHttps ? str_replace('http://', 'https://', $siteUrl) : $siteUrl;

    // Update options by adding WORDPRESSDIR constant to siteurl
    update_option('siteurl', $siteUrl.'/'.WORDPRESSDIR);
    update_option('home', $siteUrl);

    // Restore to the current blog
    restore_current_blog();
}, 10, 6);
