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
     * @var callable
     */
    protected $translator;

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
        $this->load($config);
    }

    /**
     * Load the config file
     *
     * @param string $config
     * @throws \InvalidArgumentException if no config file is found
     * @throws \Symfony\Component\Yaml\Exception\ParseException if the yaml file could not be parsed
     * @return void
     */
    public function load($config)
    {
        // Load config
        if ($config !== '') {
            $config = Config::get('root', '') . '/' . $config;

            if (!file_exists($config)) {
                throw new \InvalidArgumentException('Could not find a config file named ' . $config);
            }

            // try to parse config
            $this->config = Yaml::parse(file_get_contents($config));

            if (!is_array($this->config)) {
                $this->config = [];
            }
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
     * Set a translator to add support for localization
     *
     * @param callable $translator
     * @return void
     */
    public function setTranslator(callable $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Translate a message with the translator component
     *
     * @param string $message
     * @return string
     */
    public function translate($message)
    {
        if (!is_callable($this->translator)) {
            return $message;
        }

        return call_user_func($this->translator, $message);
    }

    /**
     * Generate the output and render it
     * @param array $data
     */
    abstract public function render(array $data = []);
}
