<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * Factory to create field classes
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class FieldFactory
{
    /**
     * Create new Field class.
     *
     * @param string $name
     * @param array $config
     * @return \PascalKleindienst\FormListGenerator\Data\Field
     */
    public function create($name, array $config)
    {
        $type = isset($config['type']) ? strtolower($config['type']) : 'text';
        $field = null;

        switch ($type) {
            case 'radio':
            case 'checkboxlist':
                $field = new RadioCheckboxList($name, $config);
                break;
            case 'section':
            case 'partial':
                $field = new PartialHTMLField($name, $config);
                break;
            default:
                $field = new Field($name, $config);
        }

        $field->setup();
        return $field;
    }
}
