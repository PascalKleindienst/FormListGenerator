<?php namespace PascalKleindienst\FormListGenerator\Generators;

use PascalKleindienst\FormListGenerator\Fields\FieldFactory;
use PascalKleindienst\FormListGenerator\Fields\AbstractField;

/**
 * Form Generator class
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
class FormGenerator extends AbstractGenerator
{
    /**
     * Fields to be removed
     * @var array
     */
    protected $remove = [];

    /**
     * Fields to be added
     * @var array
     */
    protected $add = [];

    /**
     * Custom Field Types
     * @var array
     */
    protected $customFields = [];

    /**
     * {@inheritDoc}
     */
    public function render(array $data = [], array $errors = [])
    {
        // Init
        $factory = $this->getFactory();
        $this->config['fields'] = $this->getConfigItem('fields', []);

        // Remove Fields
        foreach ($this->remove as $field) {
            if (array_key_exists($field, $this->config['fields'])) {
                unset($this->config['fields'][$field]);
            }
        }

        // Add Fields
        foreach ($this->add as $field => $options) {
            $this->config['fields'][$field] = $options;
        }

        // transform fields
        foreach ($this->config['fields'] as $field => $config) {
            $this->config['fields'][$field] = $factory->create($field, $this->translateFields($config));
        }
        
        // Render list view
        $viewData = [
            'records' => array_dot($data),
            'errors' => $errors
        ];
        $this->view->render('form', $viewData + $this->config);
    }

    /**
     * Get field factory class
     *
     * @return FieldFactory
     */
    public function getFactory()
    {
        return new FieldFactory($this->customFields);
    }

    /**
     * Mark fields which should be removed
     *
     * @param string $field
     * @return void
     */
    public function removeField($field)
    {
        $this->remove[] = $field;
    }

    /**
     * Mark fields which should be added
     *
     * @param string $field
     * @param array $options
     * @return void
     */
    public function addField($field, array $options)
    {
        $this->add[$field] = $options;
    }

    /**
     * Add a field type
     *
     * @param string $type
     * @param string|AbstractField $field
     * @throws \InvalidArgumentExceptions if $field does not inherit from AbstractField
     * @return void
     */
    public function addFieldType($type, $field)
    {
        if (is_string($field) && class_exists($field) && is_subclass_of($field, AbstractField::class)) {
            $this->customFields[$type] = $field;
            return;
        }

        throw new \InvalidArgumentException('$field must inherit from ' . AbstractTest::class);
    }

    /**
     * Translate fields
     *
     * @return array
     */
    protected function translateFields($config)
    {
        $fields = ['label', 'description', 'comment', 'placeholder'];
        foreach ($fields as $field) {
            if (array_key_exists($field, $config)) {
                $config[$field] = $this->translate($config[$field]);
            }
        }

        // Translate options
        if (array_key_exists('options', $config) && is_array($config['options'])) {
            foreach ($config['options'] as $key => $value) {
                $config['options'][$key] = $this->translate($value);
            }
        }
        
        return $config;
    }
}
