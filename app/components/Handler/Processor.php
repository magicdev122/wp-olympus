<?php

namespace Olympus\Components\Handler;

use Composer\IO\IOInterface;

/**
 * Gets its own config via composer, inspired from Incenteev ParameterHandler script.
 *
 * @category   PHP
 * @package    Olympus
 * @subpackage Components\Handler\Processor
 * @author     Achraf Chouk <achrafchouk@gmail.com>
 * @license    https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link       https://github.com/GetOlympus/Olympus
 * @see        https://github.com/Incenteev/ParameterHandler
 * @since      0.0.3
 */

class Processor
{
    /**
     * @var string
     */
    private $empty = '<info>empty</info>';

    /**
     * @var string
     */
    private $ext = '.dist';

    /**
     * @var IOInterface
     */
    private $io;

    /**
     * @var string
     */
    private $question = '<question>%s%s</question> (<comment>default: %s</comment>%s): ';

    /**
     * @var string
     */
    private $salt = 'https://api.wordpress.org/secret-key/1.1/salt/';

    /**
     * @var string
     */
    private $yes_no = 'Answer by <info>yes/y/no/n</info>';

    /**
     * Constructor.
     *
     * @param IOInterface $ioi
     *
     * @since 0.0.3
     */
    public function __construct(IOInterface $io)
    {
        $this->io = $io;
    }

    /**
     * Inform creating or updating file.
     *
     * @param  string  $realFile
     * @return bool    $exists
     *
     * @since 0.0.31
     */
    private function informAction($realFile)
    {
        // Check file
        $exists = $this->isExists($realFile);
        $action = $exists ? 'Updating' : 'Creating';

        # Write
        $this->io->write(sprintf('<info>%s the "%s" file</info>', $action, $realFile));

        return $exists;
    }

    /**
     * Check file.
     *
     * @param  string  $realFile
     * @return bool    $exists
     *
     * @since 0.0.3
     */
    private function isExists($realFile)
    {
        // Check file exists and is file
        return is_file($realFile);
    }

    /**
     * Merge recursively values.
     *
     * @param  array   $default
     * @param  array   $merge
     * @return array   $array
     *
     * @since 0.0.30
     */
    private function mergeRecursively($default, $merge)
    {
        $array = [];

        // Iterate on keys
        foreach ($default as $k => $v) {
            if (is_array($default[$k])) {
                $array[$k] = $this->mergeRecursively($default[$k], isset($merge[$k]) ? $merge[$k] : []);
                continue;
            }

            $array[$k] = isset($merge[$k]) && !empty($merge[$k]) ? $merge[$k] : $default[$k];
        }

        return $array;
    }

    /**
     * Create `config.rb` file.
     *
     * @param  string  $realFile
     *
     * @since 0.0.30
     */
    public function processDeploy($realFile)
    {
        // Check if file exists and display headers
        $exists = $this->informAction($realFile);

        // Check file and rebuild it
        if ($exists) {
            # Write
            $this->io->write(sprintf('<comment>Your "%s" already exists</comment>', $realFile));

            return;
        }

        # Write
        $this->io->write(sprintf('<comment>Your "%s" is copied from "%s"</comment>', $realFile, $realFile.$this->ext));

        // Get contents, simply
        $contents = file_get_contents($realFile.$this->ext);

        // Write in file
        file_put_contents($realFile, "# This file is auto-generated during the composer install\n\n".$contents);
    }

    /**
     * Create `env.php` file.
     *
     * @param  string  $realFile
     *
     * @since 0.0.3
     */
    public function processEnv($realFile)
    {
        // Check if file exists and display headers
        $exists = $this->informAction($realFile);

        // Find the expected params from dist file
        $expectedValues = (array) require $realFile.$this->ext;
        $actualValues   = [];

        // Update contents
        if ($exists) {
            $actualValues = (array) require $realFile;

            // Params must be stored in an array
            if (!is_array($actualValues)) {
                throw new \InvalidArgumentException(sprintf(
                    'The existing "%s" file does not contain an array',
                    $realFile
                ));
            }
        }

        // Simply use the expectedValues value as default for the missing params.
        if (!$this->io->isInteractive()) {
            $ctn  = 'Interactions are not permitted.'."\n".'Please, edit your "%s" file';
            $ctn .= ' manually to define properly your parameters.';

            $this->io->write(sprintf('<comment>'.$ctn.'</comment>'."\n", $realFile));

            $answers = $this->mergeRecursively($expectedValues, $actualValues);
        } else {
            // Build Q&A
            $answers = $this->treatParams($expectedValues, $actualValues);
        }

        # Write
        $this->io->write(sprintf('<comment>All parameters are defined now in your "%s" file</comment>', $realFile));

        // Write in file
        $ctn = "<?php\n\n/**\n * This file is auto-generated\n */\n\nreturn ".var_export($answers, true).";\n";
        file_put_contents($realFile, $ctn);
    }

    /**
     * Create `own.php` file.
     *
     * @param  string  $realFile
     *
     * @since 0.0.3
     */
    public function processOwn($realFile)
    {
        // Check if file exists and display headers
        $exists = $this->informAction($realFile);

        // Check file and rebuild it
        if ($exists) {
            # Write
            $this->io->write(sprintf('<comment>Your "%s" already exists</comment>', $realFile));

            return;
        }

        # Write
        $this->io->write(sprintf('<comment>Your "%s" is copied from "%s"</comment>', $realFile, $realFile.$this->ext));

        // Get contents, simply
        $contents = file_get_contents($realFile.$this->ext);

        // Write in file
        file_put_contents($realFile, $contents);
    }

    /**
     * Create `robots.txt` file.
     *
     * @param  string  $realFile
     * @param  string  $envFile
     *
     * @since 0.0.8
     */
    public function processRobots($realFile, $envFile)
    {
        // Check if file exists and display headers
        $exists = $this->informAction($realFile);

        // Check file and rebuild it
        if ($exists) {
            # Write
            $this->io->write(sprintf('<comment>Your "%s" already exists</comment>', $realFile));

            return;
        }

        # Write
        $this->io->write(sprintf('<comment>Your "%s" is copied from "%s"</comment>', $realFile, $realFile.$this->ext));

        // Get contents and environments, simply
        $contents = file_get_contents($realFile.$this->ext);
        $env = require $this->isExists($envFile) ? $envFile : $envFile.$this->ext;

        // Replace default URL by the configured one
        $contents = str_replace('https://www.domain.tld', $env['wordpress']['home'], $contents);

        // Write in file
        file_put_contents($realFile, "# This file is auto-generated\n\n".$contents);
    }

    /**
     * Create `salt.php` file.
     *
     * @param  string  $realFile
     *
     * @since 0.0.3
     */
    public function processSalt($realFile)
    {
        // Check if file exists and display headers
        $exists = $this->informAction($realFile);

        // Check file and rebuild it
        if ($exists) {
            # Write
            $this->io->write(sprintf('<comment>Your "%s" already exists</comment>', $realFile));

            return;
        }

        // Check curl module
        if (!function_exists('curl_init')) {
            # Write
            $this->io->write(
                "<comment>curl module is not installed. Please, install it first or get values manually.</comment>\n"
            );

            return;
        }

        # Write
        $this->io->write('<comment>Get values directly from "'.$this->salt.'"</comment>');

        // Get salt keys
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->salt);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        $salt = curl_exec($ch);
        curl_close($ch);

        // Write in file
        $ctn = "<?php\n\n/**\n * This file is auto-generated during the composer install\n */\n\n".$salt."\n";
        file_put_contents($realFile, $ctn);
    }

    /**
     * Treat params and display Q&A.
     *
     * @param  array   $expectedValues
     * @param  array   $actualValues
     * @param  bool    $isStarted
     * @param  string  $prefix
     *
     * @since 0.0.3
     */
    private function treatParams(array $expectedValues, array $actualValues, $isStarted = false, $prefix = '')
    {
        // Init vars
        $params   = [];
        $prefix   = !empty($prefix) ? $prefix.' ' : '';

        // Iterate on expected keys
        foreach ($expectedValues as $key => $value) {
            // Check if value is an array of values
            if (is_array($value)) {
                // Iterate on expected values and display Q&A with a prefix
                $params[$key] = $this->treatParams(
                    $value,
                    isset($actualValues[$key]) ? $actualValues[$key] : [],
                    $isStarted,
                    $key
                );
                continue;
            }

            // Check if value has already been set
            if (isset($actualValues[$key])) {
                // Update params
                $params = $this->updateParams($params, $key, $actualValues[$key]);
                continue;
            }

            // Display a first message before treating params
            if (!$isStarted) {
                $isStarted = true;

                # Write
                $this->io->write("\n".'<comment>Some parameters are missing. Please provide them.</comment>');
            }

            # Read
            if ('host' === $key) {
                $param = $this->io->askAndValidate(
                    sprintf($this->question, $prefix, $key, $value, ''),
                    function ($answer) {
                        $answer = trim($answer);

                        if (!filter_var($answer, FILTER_VALIDATE_IP)) {
                            throw new \Exception('The host is not a valid IPv4 or IPv6 address.');
                        }

                        return $answer;
                    },
                    3,
                    $value
                );
            } else if (in_array($key, ['name', 'user'])) {
                $param = $this->io->askAndValidate(
                    sprintf($this->question, $prefix, $key, $value, ''),
                    function ($answer) {
                        $answer = trim($answer);

                        if ('' === $answer || false !== strpos($answer, ' ')) {
                            throw new \Exception('The value cannot be empty or contain spaces.');
                        }

                        return $answer;
                    },
                    3,
                    $value
                );
            } else if ('pass' === $key) {
                $param = $this->io->askAndHideAnswer(
                    sprintf($this->question, $prefix, $key, $this->empty, '')
                );

                $param = is_null($param) ? '' : $param;
            } else if (is_bool($value)) {
                $param = $this->io->askConfirmation(
                    sprintf($this->question, $prefix, $key, !$value ? 'no' : 'yes', ' - '.$this->yes_no),
                    $value
                );
            } else {
                $param = $this->io->ask(
                    sprintf($this->question, $prefix, $key, '' === $value ? $this->empty : $value, ''),
                    $value
                );
            }

            // Update params
            $params = $this->updateParams($params, $key, $param);
        }

        return $params;
    }

    /**
     * Update params key's value.
     *
     * @param  array   $params
     * @param  string  $key
     * @param  string  $value
     * @return string  $value
     *
     * @since 0.0.25
     */
    private function updateParams($params, $key, $value)
    {
        // Home case
        if ('home' === $key && $value) {
            $url = parse_url($value);
            $params[$key] = isset($url['scheme']) ? $value : 'https://'.preg_replace('{^\/\/}', '', $value);

            return $params;
        }

        // Debug case
        if ('debug' === $key && $value) {
            $params[$key] = $this->treatParams([
                'savequeries'      => true,
                'script_debug'     => true,
                'wp_debug_display' => true,
                'wp_debug'         => true,
            ], [], $key);

            return $params;
        }

        $params[$key] = $value;
        return $params;
    }
}
