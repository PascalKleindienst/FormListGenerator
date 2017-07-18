<?php namespace PascalKleindienst\FormListGenerator\Generators;

use PascalKleindienst\FormListGenerator\Fields\FieldFactory;

/**
 * Form Generator class
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
class FormGenerator extends AbstractGenerator
{
    /**
     * {@inheritDoc}
     */
    public function render(array $data = [], array $errors = [])
    {
        // transform fields
        $factory = $this->getFactory();
        $this->config['fields'] = $this->getConfigItem('fields', []);

        foreach ($this->config['fields'] as $field => $config) {
            $this->config['fields'][$field] = $factory->create($field, $this->translateFields($config));
        }
        
        // Render list view
        $viewData = [
            'records' => $data,
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
        return new FieldFactory();
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
        
        return $config;
    }
}
