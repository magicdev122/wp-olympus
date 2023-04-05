<?php

namespace Olympus\Components\Handler;

use Composer\Script\Event;

/**
 * Gets its own config via composer, inspired from Incenteev ParameterHandler script.
 *
 * @category   PHP
 * @package    Olympus
 * @subpackage Components\Handler\Configurator
 * @author     Achraf Chouk <achrafchouk@gmail.com>
 * @license    https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link       https://github.com/GetOlympus/Olympus
 * @see        https://github.com/Incenteev/ParameterHandler
 * @since      0.0.3
 */

class Configurator
{
    /**
     * Build files on Composer install / update.
     *
     * @param  Event   $event
     *
     * @since 0.0.3
     */
    public static function build(Event $event)
    {
        $DS = DIRECTORY_SEPARATOR;

        // Get vendor path
        $vendor = $event->getComposer()->getConfig()->get('vendor-dir');

        // Instanciate Processor
        $processor = new Processor($event->getIO());

        // Build `config.rb` file
        $processor->processDeploy(dirname($vendor).$DS.'app'.$DS.'deploy'.$DS.'config.rb');

        // Build `env.php` file
        $processor->processEnv(dirname($vendor).$DS.'app'.$DS.'config'.$DS.'env.php');

        // Build `own.php` file
        $processor->processOwn(dirname($vendor).$DS.'app'.$DS.'config'.$DS.'own.php');

        // Build `salt.php` file
        $processor->processSalt(dirname($vendor).$DS.'app'.$DS.'config'.$DS.'salt.php');

        // Build `robots.txt` file
        $processor->processRobots(
            dirname($vendor).$DS.'web'.$DS.'robots.txt',
            dirname($vendor).$DS.'app'.$DS.'config'.$DS.'env.php'
        );
    }
}
