<?php namespace PascalKleindienst\FormListGenerator\Support;

/**
 * Simple View class
 * @package \PascalKleindienst\FormListGenerator\Support
 */
class View
{
    /**
     * @var null|string
     */
    protected $path;

    /**
     * @var null|string
     */
    protected $extension;

    /**
     * Set params
     *
     * @param string $path
     * @param string $extension
     */
    public function __construct($path = '', $extension = '.phtml')
    {
        // default view path
        $this->path = realpath(__DIR__ . '/../views/');

        // custom view path
        if ($path !== '') {
            $this->path = str_replace('~', Config::get('root'), $path);
        }
        
        // Extension
        $this->extension = $extension;
    }

    /**
     * Load a view file
     *
     * @param string $file
     * @param array $data
     * @return void
     * @throws \InvalidArgumentException if the file could not be found
     */
    public function render($file, array $data = [])
    {
        // Check if file exists
        $fullpath = $this->getFileName($file);
        
        if (!file_exists($fullpath)) {
            throw new \InvalidArgumentException('Could not find file with name ' . $file);
        }

        // load file
        extract($data);
        include($fullpath);
    }

    /**
     * Get the full file name
     *
     * @param string $file
     * @return string
     */
    protected function getFileName($file)
    {
        return $this->path . '/_' . $file . $this->extension;
    }

    /**
     * Return path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
