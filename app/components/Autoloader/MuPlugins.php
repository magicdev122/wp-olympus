<?php

namespace Olympus\Components\Autoloader;

/**
 * Autoload all plugins from the mu-plugins folder.
 *
 * @category   PHP
 * @package    Olympus
 * @subpackage Components\Autoloader\MuPlugins
 * @author     Achraf Chouk <achrafchouk@gmail.com>
 * @license    https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link       https://github.com/GetOlympus/Olympus
 * @since      0.0.4
 */

class MuPlugins
{
    /**
     * @var array
     */
    private $cache;

    /**
     * @var MuPlugins
     */
    private static $singleton;

    /**
     * Constructor.
     *
     * @param  bool    $is_admin
     *
     * @since 0.0.4
     */
    public function __construct($is_admin = false)
    {
        if (isset(self::$singleton)) {
            return;
        }

        self::$singleton = $this;

        if ($is_admin) {
            add_filter('show_advanced_plugins', [&$this, 'showPlugins'], 0, 2);
        }
    }

    /**
     * Run some checks then autoload our plugins.
     *
     * @since 0.0.4
     */
    public function init()
    {
        $caches = (array) $this->getCache();

        if (!$caches) {
            return;
        }

        $files = array_keys($caches);

        foreach ($files as $file) {
            // Check file to include it or not
            if (!file_exists(WPMU_PLUGIN_DIR.S.$file)) {
                $this->updateCache(true);
                continue;
            }

            // Include file and force registration
            include_once WPMU_PLUGIN_DIR.S.$file;
            do_action('activate_'.$file);
        }
    }

    /**
     * Display the autoloaded plugins.
     *
     * @param  bool    $bool
     * @param  string  $type
     * @return bool    $bool
     *
     * @since 0.0.4
     */
    public function showPlugins($bool, $type)
    {
        $screen = get_current_screen();
        $bases = ['plugins', 'plugins-network'];

        // Check capabilities
        if (!in_array($screen->base, $bases) || $type !== 'mustuse' || !current_user_can('activate_plugins')) {
            return $bool;
        }

        // Display the autoloaded plugins
        $caches = $this->getCache();
        $GLOBALS['plugins']['mustuse'] = array_unique($caches, SORT_REGULAR);

        return false;
    }

    /**
     * Gets the value of cache.
     *
     * @return array   $cache
     *
     * @since 0.0.4
     */
    public function getCache()
    {
        // Check cache
        if (empty($this->cache)) {
            $caches = $this->updateCache();
            $this->setCache($caches);
        }

        return (array) $this->cache;
    }

    /**
     * Sets the value of cache.
     *
     * @param  array   $caches
     * @return self
     *
     * @since 0.0.4
     */
    private function setCache($caches)
    {
        $this->cache = (array) $caches;

        return $this;
    }

    /**
     * Sets the value of cache.
     *
     * @param boolean $force
     * @return self
     *
     * @since 0.0.4
     */
    private function updateCache($force = false)
    {
        $cachefile = CACHEPATH.'mu-plugins.php';

        // Get cache from file
        if (file_exists($cachefile) && !$force) {
            return (array) include_once $cachefile;
        }

        include_once ABSPATH.'wp-admin'.S.'includes'.S.'plugin.php';

        // Get auto-loaded <or to autoload> mu-plugins
        $caches = get_plugins(S.'..'.S.basename(WPMU_PLUGIN_DIR));

        // Create cache file and return result
        file_put_contents(
            $cachefile,
            "<?php\n\n/**\n * File auto-generated.\n */\n\nreturn ".var_export($caches, true).";\n"
        );
        return $caches;
    }
}
