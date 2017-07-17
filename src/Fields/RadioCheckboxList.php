<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * Radio- and Checkbox List for Form generator
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class RadioCheckboxList extends AbstractField
{
    /**
     * {@inheritDoc}
     */
    protected function registerConfigKeys()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function setup()
    {
        parent::setup();
        
        $this->cssClass = str_replace('form-control', '', $this->cssClass);
    }

    /**
     * Generate a radio or checkbox list
     *
     * @param array $records
     * @return string
     */
    public function getValue(array $records = [])
    {
        // Check for options callable
        $record  = $this->getRecord($records);
        $options = $this->getOptions();
        $list    = '';

        // Add * to label if required
        if ($this->required) {
            $this->label .= ' *';
        }

        // add list items
        foreach ($options as $option => $label) {
            // Create Checkbox list or Radio Button
            if ($this->type === 'checkboxlist') {
                $this->createCheckbox($option, $record);
            } elseif ($this->type === 'radio') {
                $this->createRadio($option, $record);
            }

            // Disabled
            if ($this->disabled) {
                $this->input->disable();
            }

            // Set attributes and class
            $this->setAttributes();
            $this->input->addClass($this->cssClass);

            // Label after the radio button
            $list .= $this->labelAfterInput(' ' . $label);
        }
        
        // Label for the list
        $list = $this->builder->label($this->label)->addClass('d-block') . ' ' . $list;
        return $list;
    }

    /**
     * Create a checkbox
     *
     * @param mixed $value
     * @param mixed $record
     * @return void
     */
    protected function createCheckbox($value, $record)
    {
        $this->input = $this->builder->checkbox($this->fieldName . '[]')->value($value);

        // checked item
        if (!is_array($record) && $record == $value) {
            $this->input->check();
        } elseif (is_array($record) && in_array($value, $record)) {
            $this->input->check();
        }
    }

    /**
     * Create a radio button
     *
     * @param mixed $value
     * @param mixed $record
     * @return void
     */
    protected function createRadio($value, $record)
    {
        $this->input = $this->builder->radio($this->fieldName, $value);

        // checked item
        if ($record == $value) {
            $this->input->check();
        }
                
        $this->setRequired();
    }
}
