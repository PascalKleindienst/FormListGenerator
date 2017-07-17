<?php namespace PascalKleindienst\FormListGenerator\Generators;

use Symfony\Component\Yaml\Yaml;
use PascalKleindienst\FormListGenerator\Support\Config;
use PascalKleindienst\FormListGenerator\Support\View;

/**
 * Abstract Generator class
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
abstract class AbstractGenerator
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var \PascalKleindienst\FormListGenerator\Support\View View Library
     */
    public $view;

    /**
     * Init a new generator instance
     *
     * @param string $config YAML Config file
     * @throws \InvalidArgumentException if no config file is found
     * @throws \Symfony\Component\Yaml\Exception\ParseException if the yaml file could not be parsed
     */
    public function __construct($config = '')
    {
        // Load config
        if ($config !== '') {
            $config = Config::get('root', '') . '/' . $config;

            if (!file_exists($config)) {
                throw new \InvalidArgumentException('Could not find a config file named ' . $config);
            }

            // try to parse config
            $this->config = Yaml::parse(file_get_contents($config));
        }

        // init view lib
        $viewPath = $this->getConfigItem('customViewPath', '');
        $this->view = new View($viewPath);
    }

    /**
     * Get a item from the config array or a default value if it does not exist
     *
     * @param string $item
     * @param mixed $default
     * @return mixed
     */
    public function getConfigItem($item, $default = null)
    {
        return array_key_exists($item, $this->config) ? $this->config[$item] : $default;
    }

    /**
     * Generate the output and render it
     * @param array $data
     */
    abstract public function render(array $data = []);
}
