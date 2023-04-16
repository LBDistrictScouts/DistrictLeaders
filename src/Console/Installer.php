<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

use Cake\Utility\Security;
use Composer\IO\IOInterface;
use Composer\Script\Event;
use Exception;

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer
{
    /**
     * An array of directories to be made writable
     */
    public const WRITABLE_DIRS = [
        'logs',
        'tmp',
        'tmp/cache',
        'tmp/cache/models',
        'tmp/cache/persistent',
        'tmp/cache/views',
        'tmp/sessions',
        'tmp/tests',
    ];

    /**
     * An array of config files
     */
    public const PHP_CONFIG_FILES = [
        'app',
        'app_file',
    ];

    public const PHP_RELATIVE_CONFIG_DIRECTORY = DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
    public const YAML_RELATIVE_CONFIG_DIRECTORY = self::PHP_RELATIVE_CONFIG_DIRECTORY . 'Environment' .
    DIRECTORY_SEPARATOR;

    public const YAML_CONFIG_FILES = [
        'app_parameters',
    ];

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     * @throws \Exception Exception raised by validator.
     */
    public static function postInstall(Event $event): void
    {
        $consoleIo = $event->getIO();
        $rootDir = dirname(__DIR__, 2);

        $installMode = getenv('APP_DL_INSTALL_MODE');
        $validModes = ['NORMAL', 'CI', 'DOCKER', 'PRODUCTION'];
        if (!is_string($installMode) || !in_array($installMode, $validModes)) {
            $installMode = 'NORMAL';
        }

        $consoleIo->write('<info>Running in `' . $installMode . '` Install Mode.</info>');

        static::createAppConfig($rootDir, $consoleIo, $installMode);
        static::createWritableDirectories($rootDir, $consoleIo);

        // ask if the permissions should be changed
        if ($consoleIo->isInteractive()) {
            $booleanValidator = function ($arg) {
                if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                    return $arg;
                }
                throw new Exception('This is not a valid answer. Please choose Y or n.');
            };
            $setFolderPermissions = $consoleIo->askAndValidate(
                '<info>Set Folder Permissions ? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $booleanValidator,
                10,
                'Y'
            );

            if (in_array($setFolderPermissions, ['Y', 'y'])) {
                static::setFolderPermissions($rootDir, $consoleIo);
            }

            $appNameValidator = function ($arg) {
                $regexPattern = '/^[A-Z][A-Za-z]+$/m';
                $result = preg_match_all($regexPattern, $arg, $matches, PREG_SET_ORDER);

                if ($result) {
                    return $arg;
                }
                throw new Exception('This is not a App Name. Please use only alpha characters and PascalCase.');
            };

            $appName = $consoleIo->askAndValidate(
                '<info>Enter Application Name ? (Default to `Districtleaders`)</info>? ',
                $appNameValidator,
                10,
                'DistrictLeaders'
            );
        } else {
            static::setFolderPermissions($rootDir, $consoleIo);
            $appName = 'DistrictLeaders';
        }

        static::replacePlaceholders($rootDir, $consoleIo, $appName, '__APP_NAME__');
        static::setSecuritySalt($rootDir, $consoleIo);

        $class = 'Cake\Codeception\Console\Installer';
        if (class_exists($class)) {
            $class::customizeCodeceptionBinary($event);
        }
    }

    /**
     * Create the config/app.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $consoleIo IO interface to write to console.
     * @param string $installMode The installation mode the command is running in (e.g. in a CI/CD context).
     * @return void
     */
    public static function createAppConfig(string $dir, IOInterface $consoleIo, string $installMode): void
    {
        $configProcess = function (
            string $configDir,
            string $configFile,
            string $suffix
        ) use (
            $installMode,
            &$consoleIo
        ): void {
            $appConfig = $configDir . $configFile . $suffix;

            $default_suffix = '.default' . $suffix;
            $defaultConfig = $configDir . $configFile . $default_suffix;
            if ($installMode != 'NORMAL') {
                $default_suffix = '.' . strtolower($installMode) . $suffix;
            }

            $presentConfig = $configDir . $configFile . $default_suffix;
            if (!file_exists($presentConfig)) {
                $presentConfig = $defaultConfig;
            }

            if (!file_exists($appConfig)) {
                copy($presentConfig, $appConfig);
                $consoleIo->write('Created `' . $appConfig . '` file');
            }
        };

        // Loop through PHP config Files, like app.php & app_file.php
        $configDir = $dir . static::PHP_RELATIVE_CONFIG_DIRECTORY;
        foreach (static::PHP_CONFIG_FILES as $phpConfigFile) {
            $configProcess($configDir, $phpConfigFile, '.php');
        }

        // loop through yaml config files in the Environment Directory.
        $yamlDir = $dir . static::YAML_RELATIVE_CONFIG_DIRECTORY;
        foreach (static::YAML_CONFIG_FILES as $ymlConfigFile) {
            $configProcess($yamlDir, $ymlConfigFile, '.yml');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $consoleIo IO interface to write to console.
     * @return void
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public static function createWritableDirectories(string $dir, IOInterface $consoleIo): void
    {
        foreach (static::WRITABLE_DIRS as $path) {
            $path = $dir . '/' . $path;
            if (!file_exists($path)) {
                mkdir($path);
                $consoleIo->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $consoleIo IO interface to write to console.
     * @return void
     */
    public static function setFolderPermissions(string $dir, IOInterface $consoleIo): void
    {
        // Change the permissions on a path and output the results.
        $changePerms = function ($path) use ($consoleIo): void {
            $currentPerms = fileperms($path) & 0777;
            $worldWritable = $currentPerms | 0007;
            if ($worldWritable == $currentPerms) {
                return;
            }

            $res = chmod($path, $worldWritable);
            if ($res) {
                $consoleIo->write('Permissions set on ' . $path);
            } else {
                $consoleIo->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir) use (&$walker, $changePerms): void {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path);
                $walker($path);
            }
        };

        $walker($dir . '/tmp');
        $changePerms($dir . '/tmp');
        $changePerms($dir . '/logs');
    }

    /**
     * Set the security.salt & cookie_salt value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $consoleIo IO interface to write to console.
     * @return void
     */
    public static function setSecuritySalt(string $dir, IOInterface $consoleIo): void
    {
        $salts = [
            'Security.salt' => '__SALT__',
            'Cookie.salt' => '__COOKIE_SALT__',
        ];

        foreach ($salts as $placeHolderName => $searchString) {
            $newKey = hash('sha256', Security::randomBytes(64));
            static::replacePlaceholders($dir, $consoleIo, $newKey, $searchString, $placeHolderName);
        }
    }

    /**
     * Set a Placeholder value in a given file
     *
     * @param string $dir The root directory.
     * @param \Composer\IO\IOInterface $consoleIo IO interface to write to console.
     * @param string $value Value to be left in place of the Search Token.
     * @param string $searchToken The Token to Replace in File
     * @param string|null $placeHolderName The Name to emit in the IO
     * @return void
     */
    public static function replacePlaceholders(
        string $dir,
        IOInterface $consoleIo,
        string $value,
        string $searchToken,
        ?string $placeHolderName = null
    ): void {
        $php_config_dir = $dir . static::PHP_RELATIVE_CONFIG_DIRECTORY;
        foreach (static::PHP_CONFIG_FILES as $php_config) {
            $config_file = $php_config_dir . $php_config . '.php';
            static::replacePlaceholder($config_file, $consoleIo, $value, $searchToken, $placeHolderName);
        }

        $yaml_config_dir = $dir . static::YAML_RELATIVE_CONFIG_DIRECTORY;
        foreach (static::YAML_CONFIG_FILES as $yaml_config) {
            $config_file = $yaml_config_dir . $yaml_config . '.yml';
            static::replacePlaceholder($config_file, $consoleIo, $value, $searchToken, $placeHolderName);
        }
    }

    /**
     * Set a Placeholder value in a given file
     *
     * @param string $config The Config File being processed.
     * @param \Composer\IO\IOInterface $consoleIo IO interface to write to console.
     * @param string $value Value to be left in place of the Search Token.
     * @param string $searchToken The Token to Replace in File
     * @param string|null $placeHolderName The Name to emit in the IO
     * @return void
     */
    public static function replacePlaceholder(
        string $config,
        IOInterface $consoleIo,
        string $value,
        string $searchToken,
        ?string $placeHolderName = null
    ): void {
        $content = file_get_contents($config);
        $placeHolderName ??= $searchToken;

        $content = str_replace($searchToken, $value, $content, $count);

        if ($count == 0) {
            $consoleIo->write('No ' . $placeHolderName . ' placeholder to replace in ' . $config . '.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $consoleIo->write('Updated ' . $placeHolderName . ' value in config/' . $config);

            return;
        }
        $consoleIo->write('Unable to update ' . $placeHolderName . ' value in ' . $config . '.');
    }
}
