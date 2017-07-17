<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * Field for Form generator
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class Field extends AbstractField
{
    /**
     * @var string Specify a placeholder for the input
     */
    public $placeholder = '';

    /**
     * @var mixed Default value for the input element
     */
    public $default;

    /**
     * {@inheritDoc}
     */
    protected function registerConfigKeys()
    {
        return [ 'placeholder' ];
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(array $records = [])
    {
        // Types
        $this->initInputType($this->getRecord($records));
        
        // Attributes
        $this->setAttributes();

        // Disabled
        if ($this->disabled) {
            $this->input->disable();
        }

        // Readonly
        if ($this->readOnly) {
            $this->input->attribute('readonly', true);
        }

        // required
        $this->setRequired(' *');

        // Placeholder
        if ($this->placeholder !== '') {
            $this->input->placeholder($this->placeholder);
        }
        
        // Label
        if (isset($this->config['comment'])) {
            $this->cssClass = str_replace('form-control', '', $this->cssClass);
            $this->input = $this->labelAfterInput(' ' . $this->config['comment']);
        }

        // Css
        $this->input->addClass($this->cssClass);

        return $this->builder->label($this->label)->addClass('d-block')->before($this->input);
    }

    /**
     * Initialize the input field based on the type
     *
     * @param mixed $record
     * @return void
     */
    protected function initInputType($record)
    {
        // init input
        switch ($this->type) {
            case 'password':
                $this->input = $this->builder->password($this->fieldName);
                break;
            case 'date':
                $this->input = $this->builder->date($this->fieldName);
                break;
            case 'email':
                $this->input = $this->builder->email($this->fieldName);
                break;
            case 'textarea':
                $this->input = $this->builder->textarea($this->fieldName);
                break;
            case 'dropdown':
                $this->input = $this->builder->select($this->fieldName, $this->getOptions())->select($record);
                break;
            case 'checkbox':
                $this->input = $this->builder->checkbox($this->fieldName);

                if ($this->default) {
                    $this->input->check();
                }
                
                $this->input->value($record);
                break;
            default:
                $this->input = $this->builder->text($this->fieldName);
        }

        // set value and default value
        if ($this->type === 'date') {
            $this->input->value(new \DateTime($record));
        } elseif ($this->type !== 'dropdown' && $this->type !== 'checkbox') {
            $this->input->value($record)->defaultValue($this->default);
        }
    }
}
