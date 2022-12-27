<?php
declare(strict_types=1);

namespace App\Command;

use AWS\Sdk;
use Aws\Ssm\SsmClient;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Inflector;
use Exception;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 */
class ParamStoreCommand extends Command
{
    use MailerAwareTrait;

    protected $configKey = 'ConfigKeys';

    protected $secureKeys = 'SecureKeys';

    protected $configFile = 'config_keys';

    protected $outputFile = 'Environment' . DS . 'app_parameters';

    protected $configEngine = 'yaml';

    protected $pathRoot;

    protected $overwrite = true;

    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        Configure::load('environment', $this->configEngine);
        Configure::load($this->outputFile, $this->configEngine);
        Configure::load('app', 'default');

        $pathR = '/' . Configure::read('App.app_ref', 'leaders');
        $pathR .= '/' . Configure::read('Environment');
        $this->pathRoot = strtolower($pathR);

        parent::initialize();
    }

    /**
     * @param ConsoleOptionParser $parser Parser Input
     * @return ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Dump Config Values.');

        $parser
            ->addOption('Write', [
                'short' => 'w',
                'help' => 'Write Parameters',
                'boolean' => true,
            ])
            ->addOption('Remove', [
                'short' => 'r',
                'help' => 'Remove Parameters from App Config',
                'boolean' => true,
            ])
            ->addOption('Get', [
                'short' => 'g',
                'help' => 'Get App Config from Remote',
                'boolean' => true,
            ])
            ->addOption('Info', [
                'short' => 'i',
                'help' => 'Output Environment Info',
                'boolean' => true,
            ])
            ->addOption('Setup', [
                'short' => 's',
                'help' => 'Setup Parameter File',
                'boolean' => true,
            ]);

        return $parser;
    }

    /**
     * @param string $key Parameter Key
     * @return string
     */
    protected function makePath($key)
    {
        return $this->pathRoot . '/' . Inflector::dasherize($key);
    }

    /**
     * @param string $path Path to be reversed
     * @return string
     */
    protected function reversePath($path)
    {
        return Inflector::camelize(explode('/', $path, 4)[3], '-');
    }

    /**
     * @param array $configKeys Configuration keys to be parsed into paths
     * @return array
     */
    protected function makePaths(array $configKeys)
    {
        $paths = [];

        foreach ($configKeys as $configKey) {
            $path = $this->makePath($configKey);
            array_push($paths, $path);
        }

        return $paths;
    }

    /**
     * @return array|false
     */
    protected function getList()
    {
        Configure::load($this->configFile, 'yaml');

        return Configure::consume($this->configKey);
    }

    /**
     * @return SsmClient
     */
    protected function makeClient()
    {
        $sharedConfig = [
            'region' => 'eu-west-1',
            'version' => 'latest',
        ];

        $sdk = new Sdk($sharedConfig);

        return $sdk->createSsm();
    }

    /**
     * @param array $storeList List of Parameters to be Stored in File
     * @return void
     */
    protected function dumpParameters(array $storeList)
    {
        if (!empty($storeList)) {
            Configure::dump($this->outputFile, $this->configEngine, $storeList);
        }
    }

    /**
     * @return int|void
     */
    protected function getParameters()
    {
        $list = $this->getList();
        $storeList = [];

        $rateLimited = array_chunk($list, 10);

        foreach ($rateLimited as $paramChunk) {
            $result = $this->makeClient()->getParameters([
                'Names' => $this->makePaths($paramChunk), // REQUIRED
                'WithDecryption' => true,
            ]);

            $parameters = $result->get('Parameters');

            foreach ($parameters as $parameter) {
                $key = $this->reversePath($parameter['Name']);
                $value = json_decode($parameter['Value'], true);
                Configure::write($key, $value);
                array_push($storeList, $key);
            }
            sleep(1);
        }

        $this->dumpParameters($storeList);

        return count($storeList);
    }

    /**
     * @param string $param Parameter Name
     * @return bool
     */
    protected function writeParameter(string $param)
    {
        $path = $this->makePath($param);

        $type = 'String';
        if (in_array($param, Configure::read($this->secureKeys))) {
            $type = 'SecureString';
        }

        $requestArray = [
            'Name' => $path,
            'Overwrite' => $this->overwrite,
            'Tier' => 'Standard',
            'Type' => $type,
            'Value' => json_encode(Configure::read($param)), // REQUIRED
        ];

        $this->makeClient()->putParameter($requestArray);

        return true;
    }

    /**
     * @return int
     */
    protected function writeParameters()
    {
        $params = $this->getList();
        $count = 0;

        $rateLimit = array_chunk($params, 5);

        foreach ($rateLimit as $paramList) {
            foreach ($paramList as $param) {
                if ($this->writeParameter($param)) {
                    $count += 1;
                }
            }
            sleep(1);
        }

        return $count;
    }

    /**
     * @return void
     */
    protected function removeParameters()
    {
        $configKeys = Configure::read();

        $excluded = [
            'plugins', // Autogenerated
            'DebugKit', // Dynamic
            'Environment', // Key for Environment
            $this->configKey,
            $this->secureKeys,
            'IncludedAppConfigKeys',
            'ExcludedAppConfigKeys',
            'ApplicationConfigKeys',
        ];

        $excluded = array_merge($excluded, $this->getList());
        $excluded = array_merge($excluded, Configure::read('ExcludedAppConfigKeys'));
        $excluded = array_merge($excluded, Configure::read('ApplicationConfigKeys'));

        foreach ($excluded as $excludeKey) {
            unset($configKeys[$excludeKey]);
        }

        $included = array_keys($configKeys);
        $included = array_merge($included, Configure::read('IncludedAppConfigKeys'));
        Configure::dump('app', 'default', $included);

        $this->writeParameters();
    }

    /**
     * @return void
     */
    protected function setupParameters()
    {
        Configure::load('app.default', 'default');
        $this->writeParameters();
    }

    /**
     * @param ConsoleIo $consoleIo The console for Output
     * @return void
     */
    protected function echoInfo(ConsoleIo $consoleIo)
    {
        $indent = '     ';

        $consoleIo->out('Environment');
        $consoleIo->warning($indent . 'Root Path: ' . $this->pathRoot);
        $consoleIo->warning($indent . 'Application: ' . Configure::read('App.app_ref'));
        $consoleIo->warning($indent . 'Environment: ' . Configure::read('Environment'));

        $consoleIo->out('Active Config Keys:');
        foreach ($this->getList() as $listKey) {
            $consoleIo->warning($indent . $listKey);
        }
    }

    /**
     * @param Arguments $args Arguments for the Console
     * @param ConsoleIo $consoleConsoleIo The IO
     * @return int|void|null
     * @throws Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleConsoleIo)
    {
        if ($args->getOption('Info')) {
            $this->echoInfo($consoleConsoleIo);
        }

        if ($args->getOption('Write')) {
            $count = $this->writeParameters();
            $consoleConsoleIo->info('Wrote ' . $count . ' Parameters');
        }

        if ($args->getOption('Get')) {
            $this->getParameters();
            $consoleConsoleIo->info('Got Parameters');

            if ($args->getOption('Remove')) {
                $this->removeParameters();
                $consoleConsoleIo->info('Removed Parameters from App Config File');
            }
        }

        if ($args->getOption('Setup')) {
            $this->setupParameters();
            $consoleConsoleIo->info('Setup Parameters');
        }
    }
}
