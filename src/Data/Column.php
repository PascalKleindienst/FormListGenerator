<?php namespace PascalKleindienst\FormListGenerator\Data;

use PascalKleindienst\FormListGenerator\Support\Config;

/**
 * Columns for list generator
 * @package \PascalKleindienst\FormListGenerator\Data
 */
class Column
{
    /**
     * @var string List column name.
     */
    public $columnName;

    /**
     * @var string List column label.
     */
    public $label;

    /**
     * @var string Display mode. Text, number
     */
    public $type = 'text';

    /**
     * @var boolean Specifies whether a column is clickable or not
     */
    public $clickable = true;

    /**
     * @var string Specifies a default value when value is empty.
     */
    public $default;

    /**
     * @var string Specify a CSS class to attach to the list cell element.
     */
    public $cssClass;

    /**
     * @var string Specify a format or style for the column value, such as a Date.
     */
    public $format;

    /**
     * @var string Specifies a path for partial-type fields.
     */
    public $path;

    /**
     * @var array Raw field configuration.
     */
    public $config;

    /**
     * @var string Record Url
     */
    protected $recordUrl;

    /**
     * Constructor.
     * @param string $name
     * @param array $config
     * @param string $recordUrl
     */
    public function __construct($name, array $config, $recordUrl)
    {
        $this->columnName = $name;
        $this->config = $config;
        $this->recordUrl = $recordUrl;
        $this->setup();
    }

    /**
     * Setup the column properties
     *
     * @return void
     */
    protected function setup()
    {
        // type
        $this->type = isset($this->config['type']) ? strtolower($this->config['type']) : 'text';

        // save value of properties if they exist
        $configKeys = ['cssClass', 'default', 'format', 'path', 'label', 'clickable'];

        foreach ($configKeys as $key) {
            if (isset($this->config[$key])) {
                $this->{$key} = $this->config[$key];
            }
        }
        
        // save path
        $this->path = str_replace('~', Config::get('root'), $this->path);
    }

    /**
     * Get the value for the column from the record
     *
     * @param array $record
     * @return void|string
     */
    public function getValue(array $record)
    {
        // get value or default value if record does not exist
        $value = $this->default;
        if (array_key_exists($this->columnName, $record)) {
            $value = $record[$this->columnName];
        }
        
        // format date
        if ($this->type === 'date') {
            $value = date($this->format, $value);
        }

        // format number
        if ($this->type === 'number') {
            $value = '<div class="text-right">' . $value . '</div>';
        }
        
        // load partial
        if ($this->type === 'partial' && file_exists($this->path)) {
            include($this->path);
            return;
        }

        return $value;
    }

    /**
     * Get the record url
     *
     * @param array $record
     * @return string
     */
    public function getRecordUrl(array $record)
    {
        // search patterns ala :id basend on record fields
        $search = array_map(
            function ($value) {
                return ":$value";
            },
            array_keys($record)
        );
        
        return str_replace($search, $record, $this->recordUrl);
    }
}
