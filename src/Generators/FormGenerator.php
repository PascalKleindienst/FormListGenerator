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
    public function render(array $data = [])
    {
        // transform fields
        $factory = $this->getFactory();
        $this->config['fields'] = $this->getConfigItem('fields', []);

        foreach ($this->config['fields'] as $field => $config) {
            $this->config['fields'][$field] = $factory->create($field, $config);
        }
        
        // Render list view
        $viewData = [
            'records' => $data
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
}