<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * PartialHTMLField Test Class
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class PartialHTMLFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValueForSection()
    {
        $config = [
            'type' => 'section',
            'label' => 'I am a label',
            'comment' => 'I am a comment'
        ];

        $field = new PartialHTMLField('section', $config);
        $field->setup();

        $this->assertEquals(
            '<h2>' . $config['label'] . '</h2><p>' . $config['comment'] . '</p>',
            $field->getValue()
        );
    }

    public function testGetValueForPath()
    {
        ob_start();
        $config = [
            'type' => 'partial',
            'path' => __DIR__ . '/../views/_col_partial.phtml'
        ];

        $field = new PartialHTMLField('partial', $config);
        $field->setup();

        $field->getValue(['partial' => 'foo']);
        $this->assertEquals('Col Partial foo', ob_get_contents());
        ob_end_clean();
    }

    /**
     * @dataProvider configkeys
     *
     * @return void
     */
    public function testConfigKeys($config, $property, $expected)
    {
        $field = new PartialHTMLField('test-' . $property, $config);
        $field->setup();
        
        $this->assertEquals($expected, $field->{$property});
    }

    public function configkeys()
    {
        return [
            'test comment property' => [['comment' => 'Comment'], 'comment', 'Comment'],
            'test path property' => [['path' => 'Path'], 'path', 'Path']
        ];
    }
}
