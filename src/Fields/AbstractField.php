<?php namespace PascalKleindienst\FormListGenerator\Fields;

use AdamWathan\Form\FormBuilder;

/**
 * Abstract Field for Form generator
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
abstract class AbstractField
{
    /**
     * @var string List field name.
     */
    public $fieldName;

    /**
     * @var string Display mode. Text, number
     */
    public $type = 'text';

    /**
     * @var string The label of the field
     */
    public $label;

    /**
     * @var string Specifies a default value when value is empty.
     */
    public $default;

    /**
     * @var string Specify a CSS class to attach to the input element.
     */
    public $cssClass;

    /**
     * @var array Raw field configuration.
     */
    public $config;

    /**
     * @var array Array of attributes for the input element
     */
    public $attributes = [];

    /**
     * @var boolean Whether the input is disabled or not
     */
    public $disabled = false;

    /**
     * @var boolean Whether the input is required or not
     */
    public $required = false;

    /**
     * @var boolean Whether the input is readonly or not
     */
    public $readOnly = false;

    /**
     * @var string Description which is displayed under the input element
     */
    public $description;

    /**
     * @var \AdamWathan\Form\FormBuilder
     */
    protected $builder;

    /**
     * @var \AdamWathan\Form\Elements\Element
     */
    protected $input;

    /**
     * Register Config keys
     *
     * @return array
     */
    abstract protected function registerConfigKeys();

    /**
     * Constructor.
     * @param string $name
     * @param array $config
     */
    public function __construct($name, array $config)
    {
        $this->fieldName = $name;
        $this->config = $config;
        $this->builder = new FormBuilder();
    }

    /**
     * Setup the field properties
     *
     * @return void
     */
    public function setup()
    {
        // type
        $this->type = isset($this->config['type']) ? strtolower($this->config['type']) : $this->type;

        // save value of properties if they exist
        $configKeys = $this->registerConfigKeys() +  ['cssClass', 'default', 'description', 'label', 'readOnly', 'disabled', 'required', 'attributes'];

        foreach ($configKeys as $key) {
            if (isset($this->config[$key])) {
                $this->{$key} = $this->config[$key];
            }
        }

        // css class
        $this->cssClass .= ' form-control';
    }

    /**
     * Set attributes for the input
     *
     * @return void
     */
    protected function setAttributes()
    {
        foreach ($this->attributes as $attr => $val) {
            $this->input->attribute($attr, $val);
        }
    }

    /**
     * Mark input as required if necessary
     *
     * @param string $labelSuffix add a suffix like '*' to the label
     * @return void
     */
    protected function setRequired($labelSuffix = '')
    {
        if ($this->required) {
            $this->label .= $labelSuffix;
            $this->input->required();
        }
    }

    /**
     * Add a label after the input
     *
     * @param string $label
     * @param string $class
     * @return \AdamWathan\Form\Elements\Element
     */
    protected function labelAfterInput($label, $class = 'd-block')
    {
        return $this->builder->label($label)->addClass($class)->after($this->input);
    }

    /**
     * Get the record for this field
     *
     * @param array $records
     * @return mixed
     */
    protected function getRecord(array $records)
    {
        return array_key_exists($this->fieldName, $records) ? $records[$this->fieldName] : null;
    }

    /**
     * Get option values for dropdown, radio and checkboxes
     *
     * @return array
     */
    protected function getOptions()
    {
        // Check for options callable
        $options = $this->options;
        if (is_callable($options)) {
            $options = call_user_func($options);
        }

        return $options;
    }
}
