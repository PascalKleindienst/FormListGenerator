<?php namespace PascalKleindienst\FormListGenerator\Data;

/**
 * Column Test Class
 * @package \PascalKleindienst\FormListGenerator\Data
 */
class ColumnTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $col = new Column('test', [], '');
        $this->assertEquals('test', $col->columnName);
        $this->assertEmpty($col->config);
    }

    public function testGetRecordUrl()
    {
        $col = new Column('test', [], '/foo/bar/:baz');
        $this->assertEquals('/foo/bar/42', $col->getRecordUrl(['baz' => '42']));
    }

    public function testSetupEmptyConfig()
    {
        $col = new Column('', [], '');
        
        $this->assertEquals('text', $col->type);
        $this->assertTrue($col->clickable);
        $this->assertEquals('', $col->columnName, 'Empty Column Name');
        $this->assertEquals('', $col->path, 'Empty path');
        $this->assertNull($col->label, 'Label not set');
        $this->assertNull($col->default, 'Default not set');
        $this->assertNull($col->cssClass, 'cssClass not set');
        $this->assertNull($col->format, 'Format not set');
        $this->assertEmpty($col->config, 'Empty Config');
    }

    public function testSetupWithConfig()
    {
        $config = [
            'type'      => 'number',
            'clickable' => true,
            'label'     => 'I am a label',
            'default'   => 'Default value',
            'cssClass'  => 'my-awesome-class my-other-awesome-class',
            'format'    => 'd.m.Y',
            'path'      => '../views/'
        ];
        $col = new Column('', $config, '');
        
        $this->assertEquals($config['type'], $col->type);
        $this->assertEquals($config['clickable'], $col->clickable);
        $this->assertEquals($config['label'], $col->label);
        $this->assertEquals($config['default'], $col->default);
        $this->assertEquals($config['cssClass'], $col->cssClass);
        $this->assertEquals($config['format'], $col->format);
        $this->assertEquals($config['path'], $col->path);
    }
    
    /**
     * @dataProvider provider
     */
    public function testGetValue($column, $config, $expected)
    {
        $record =  [
            'full_name'  => 'John Doe',
            'age'        => 42,
            'created_at' => time(),
            'content'    => 'lorem ipsum',
            'default'    => null
        ];
        $col = new Column($column, $config, '');
        
        $this->assertEquals($expected($record[$column]), $col->getValue($record));
    }

    public function testGetDefaultValue()
    {
        $record =  [];
        $col = new Column('default', ['default' => 42], '');
        
        $this->assertEquals(42, $col->getValue($record));
    }

    public function testGetPartialValue()
    {
        ob_start();
        $record =  ['content' => 'lorem ipsum'];
        $col = new Column('content', ['type' => 'partial', 'path' => __DIR__ . '/../views/' . '_col_partial.phtml'], '');
        
        $col->getValue($record);
        $this->assertEquals('Col Partial ' . $record['content'], ob_get_contents());
        ob_end_clean();
    }

    public function provider()
    {
        return [
           'text column'   => ['full_name', ['type' => 'text'], function ($record) {
               return $record;
           }],
           'number column' => ['age', ['type' => 'number'], function ($record) {
               return '<div class="text-right">' . $record . '</div>';
           }],
           'date column'   => ['created_at', ['type' => 'date', 'format' => 'd.m.Y'], function ($record) {
               return date('d.m.Y', $record);
           }]
        ];
    }
}
