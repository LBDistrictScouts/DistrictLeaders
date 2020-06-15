<?php
declare(strict_types=1);

namespace App\Configure\Engine;

use Cake\Core\Configure\ConfigEngineInterface;
use Cake\Core\Configure\FileConfigTrait;
use Cake\Core\Exception\Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfig
 *
 * @package App\Configure\Engine
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class YamlConfig implements ConfigEngineInterface
{
    use FileConfigTrait;

    protected $_extension = '.yml';

    /**
     * Method: __construct
     *
     * @param mixed $path Path
     * @return void
     */
    public function __construct($path = null)
    {
        if ($path === null) {
            $path = CONFIG;
        }
        $this->_path = $path;
    }

    /**
     * @param string $key Key
     * @return array
     */
    public function read(string $key): array
    {
        $file = $this->_getFilePath($key, true);
        $input = file_get_contents($file);
        $config = Yaml::parse($input);
        if (is_array($config)) {
            return $config;
        } else {
            throw new Exception(sprintf('Config file "%s" did not return an array', $key . '.php'));
        }
    }

    /**
     * Method: dump
     *
     * @param mixed $key Key
     * @param array $data Data
     * @return bool Success
     */
    public function dump($key, array $data): bool
    {
        $filename = $this->_getFilePath($key);

        $yamlBody = Yaml::dump($data, 3);

        return file_put_contents($filename, $yamlBody) > 0;
    }
}
