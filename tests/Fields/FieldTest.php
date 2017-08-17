<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * Field Test Class
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class FieldTest extends \PHPUnit_Framework_TestCase
{
    protected function createField($name, $config = [])
    {
        $field = new Field($name, $config);
        $field->setup();
        
        return $field;
    }

    /* public function testConfigKeys()
    {
        $field = $this->createField('test-options', ['options' => 'Some opts']);
        $this->assertEquals('Some opts', $field->options);
    }

    public function testSetup()
    {
        $field = $this->createField('test-cssClass', []);
        $this->assertEquals(' ', $field->cssClass);
    } */


    /**
     * @dataProvider provider
     */
    public function testGetValue($record, $config, $expected)
    {
        $field = $this->createField('record', $config);
        $value = (string)$field->getValue($record);
        $this->assertEquals($expected, $value);
    }

    public function provider()
    {
        return [
            'default input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label' ],
                '<label class="d-block">Label<input type="text" name="record" value="Value" class=" form-control"></label>'
            ],
            'default input with default value' => [
                ['record' => null],
                [ 'label' => 'Label', 'default' => 'Default' ],
                '<label class="d-block">Label<input type="text" name="record" value="Default" class=" form-control"></label>'
            ],
            'disabled input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'disabled' => true ],
                '<label class="d-block">Label<input type="text" name="record" value="Value" disabled="disabled" class=" form-control"></label>'
            ],
            'readonly input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label',  'readOnly' => true ],
                '<label class="d-block">Label<input type="text" name="record" value="Value" readonly="1" class=" form-control"></label>'
            ],
            'required input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'required' => true ],
                '<label class="d-block">Label *<input type="text" name="record" value="Value" required="required" class=" form-control"></label>'
            ],
            'css input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'cssClass' => 'csstest' ],
                '<label class="d-block">Label<input type="text" name="record" value="Value" class="csstest form-control"></label>'
            ],
            'placeholder input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'placeholder' => 'placeholder test' ],
                '<label class="d-block">Label<input type="text" name="record" value="Value" placeholder="placeholder test" class=" form-control"></label>'
            ],
            'comment input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'comment' => 'Input with comment' ],
                '<label class="d-block">Label<label class="d-block  "><input type="text" name="record" value="Value"> Input with comment</label></label>'
            ],
            'password input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'type' => 'password' ],
                '<label class="d-block">Label<input type="password" name="record" value="Value" class=" form-control"></label>'
            ],
            'date input' => [
                ['record' => '2017-05-04'],
                [ 'label' => 'Label', 'type' => 'date' ],
                '<label class="d-block">Label<input type="date" name="record" value="2017-05-04" class=" form-control"></label>'
            ],
            'email input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'type' => 'email' ],
                '<label class="d-block">Label<input type="email" name="record" value="Value" class=" form-control"></label>'
            ],
            'number input' => [
                ['record' => '42'],
                [ 'label' => 'Label', 'type' => 'number' ],
                '<label class="d-block">Label<input type="number" name="record" value="42" class=" form-control"></label>'
            ],
            'file input' => [
                ['record' => 'http://via.placeholder.com/350x150'],
                [ 'label' => 'Label', 'type' => 'file' ],
                '<label class="d-block">Label<input type="file" name="record" value="http://via.placeholder.com/350x150" class=" form-control"></label>'
            ],
            'image input' => [
                ['record' => 'http://via.placeholder.com/350x150'],
                [ 'label' => 'Label', 'type' => 'image' ],
                '<label class="d-block">Label<br/> <img src="http://via.placeholder.com/350x150" class="preview_record" /><input type="file" name="record" accept="image/*" value="http://via.placeholder.com/350x150" class=" form-control"></label>'
            ],
            'textarea input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'type' => 'textarea' ],
                '<label class="d-block">Label<textarea name="record" rows="10" cols="50" class=" form-control">Value</textarea></label>'
            ],
            'dropdown input' => [
                ['record' => 2],
                [ 'label' => 'Label', 'type' => 'dropdown', 'options' => [1=>1, 2=>2] ],
                '<label class="d-block">Label<select name="record" class=" form-control"><option value="1">1</option><option value="2" selected>2</option></select></label>'
            ],
            'checkbox input' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'type' => 'checkbox' ],
                '<label class="d-block">Label<input type="checkbox" name="record" value="Value" class=" form-control"></label>'
            ],
            'checkbox input default' => [
                ['record' => 'Value'],
                [ 'label' => 'Label', 'type' => 'checkbox', 'default' => true],
                '<label class="d-block">Label<input type="checkbox" name="record" value="Value" checked="checked" class=" form-control"></label>'
            ],
        ];
    }
}
