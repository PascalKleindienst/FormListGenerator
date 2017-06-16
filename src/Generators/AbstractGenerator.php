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
        $viewPath = array_key_exists('customViewPath', $this->config) ? $this->config['customViewPath'] : '';
        $this->view = new View($viewPath);
    }

    /**
     * Generate the output and render it
     * @param array $data
     */
    abstract public function render(array $data = []);
}
