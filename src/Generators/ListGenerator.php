<?php namespace PascalKleindienst\FormListGenerator\Generators;

use PascalKleindienst\FormListGenerator\Data\Column;

/**
 * List Generator class
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
class ListGenerator extends AbstractGenerator
{
    /**
     * {@inheritDoc}
     */
    public function render(array $data = [])
    {
        // transform columns
        $this->config['columns'] = $this->getConfigItem('columns', []);
        
        foreach ($this->config['columns'] as $column => $config) {
            $config['label'] = $this->translate($config['label']);
            $this->config['columns'][$column] = $this->createColumn($column, $config);
        }

        // Translate no records message
        if (array_key_exists('noRecordsMessage', $this->config)) {
            $this->config['noRecordsMessage'] = $this->translate($this->config['noRecordsMessage']);
        }
        
        // Render list view
        $viewData = [
            'records' => $data,
            'columnTotal' => count($this->config['columns'])
        ];

        $this->view->render('list', $viewData + $this->config);
    }

    /**
     * Create new column
     *
     * @param string $column
     * @param array $config
     * @return Column
     */
    public function createColumn($column, $config)
    {
        return new Column($column, $config, $this->config['recordUrl']);
    }
}
