<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * RadioCheckboxList Test Class
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class RadioCheckboxListTest extends \PHPUnit_Framework_TestCase
{
    protected function createField($name, $config = [])
    {
        $field = new RadioCheckboxList($name, $config);
        $field->setup();
        
        return $field;
    }

    public function testConfigKeys()
    {
        $field = $this->createField('test-options', ['options' => 'Some opts']);
        $this->assertEquals('Some opts', $field->options);
    }

    public function testSetup()
    {
        $field = $this->createField('test-cssClass', []);
        $this->assertEquals(' ', $field->cssClass);
    }

    public function testRequired()
    {
        $field = $this->createField('test-required', ['required' => true]);
        $field->getValue();
        $this->assertEquals(' *', $field->label);
    }

    /**
     * @dataProvider provider
     */
    public function testGetValue($record, $config, $expected)
    {
        $field = $this->createField('record', $config);
        $value = $field->getValue($record);
        $this->assertEquals($expected, $value);
    }

    public function provider()
    {
        return [
            'default checkboxlist' => [
                ['record' => 1],
                [
                    'type' => 'checkboxlist',
                    'label' => 'Label',
                    'options' => [1 => 'Opt 1', 2 => 'Opt 2']
                ],
                '<label class="d-block">Label</label> ' .
                '<label class="d-block"><input type="checkbox" name="record[]" value="1" checked="checked" class=" "> Opt 1</label>' .
                '<label class="d-block"><input type="checkbox" name="record[]" value="2" class=" "> Opt 2</label>'
            ],
            'disabled checkboxlist' => [
                ['record' => [1]],
                [
                    'type' => 'checkboxlist',
                    'label' => 'Label',
                    'disabled' => true,
                    'options' => [1 => 'Opt 1', 2 => 'Opt 2']
                ],
                '<label class="d-block">Label</label> ' .
                '<label class="d-block"><input type="checkbox" name="record[]" value="1" checked="checked" disabled="disabled" class=" "> Opt 1</label>' .
                '<label class="d-block"><input type="checkbox" name="record[]" value="2" disabled="disabled" class=" "> Opt 2</label>'
            ],
            'checkboxlist with attributes' => [
                ['record' => 'record'], // no checked record
                [
                    'type' => 'checkboxlist',
                    'label' => 'Label',
                    'attributes' => ['id' => 'test'],
                    'options' => [1 => 'Opt 1', 2 => 'Opt 2']
                ],
                '<label class="d-block">Label</label> ' .
                '<label class="d-block"><input type="checkbox" name="record[]" value="1" id="test" class=" "> Opt 1</label>' .
                '<label class="d-block"><input type="checkbox" name="record[]" value="2" id="test" class=" "> Opt 2</label>'
            ],
            'default radio' => [
                ['record' => 1],
                [
                    'type' => 'radio',
                    'label' => 'Label',
                    'options' => [1 => 'Opt 1', 2 => 'Opt 2']
                ],
                '<label class="d-block">Label</label> ' .
                '<label class="d-block"><input type="radio" name="record" value="1" checked="checked" class=" "> Opt 1</label>' .
                '<label class="d-block"><input type="radio" name="record" value="2" class=" "> Opt 2</label>'
            ],
            'disabled radio' => [
                ['record' => 1],
                [
                    'type' => 'radio',
                    'label' => 'Label',
                    'disabled' => true,
                    'options' => [1 => 'Opt 1', 2 => 'Opt 2']
                ],
                '<label class="d-block">Label</label> ' .
                '<label class="d-block"><input type="radio" name="record" value="1" checked="checked" disabled="disabled" class=" "> Opt 1</label>' .
                '<label class="d-block"><input type="radio" name="record" value="2" disabled="disabled" class=" "> Opt 2</label>'
            ],
            'radio with attributes' => [
                ['record' => 'record'], // no checked record
                [
                    'type' => 'radio',
                    'label' => 'Label',
                    'attributes' => ['id' => 'test'],
                    'options' => [1 => 'Opt 1', 2 => 'Opt 2']
                ],
                '<label class="d-block">Label</label> ' .
                '<label class="d-block"><input type="radio" name="record" value="1" id="test" class=" "> Opt 1</label>' .
                '<label class="d-block"><input type="radio" name="record" value="2" id="test" class=" "> Opt 2</label>'
            ]
        ];
    }
}
