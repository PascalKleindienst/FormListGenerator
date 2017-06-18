<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * AbstractField Test Class
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class AbstractFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * get Mock for \PascalKleindienst\FormListGenerator\Fields\AbstractField
     *
     * @param array $args Contructor args
     * @return \PascalKleindienst\FormListGenerator\Fields\AbstractField
     */
    public function getFieldMock(array $args = [])
    {
        $stub = $this->getMockForAbstractClass(AbstractField::class, $args);

        $stub->expects($this->any())
             ->method('registerConfigKeys')
             ->will($this->returnValue([]));
        
        $stub->setup();

        return $stub;
    }

    /**
     * @dataProvider configProvider
     */
    public function testSetup($config, $property, $expected)
    {
        $mock = $this->getFieldMock(['test-property-' . $property, $config]);
        
        $this->assertEquals($expected, $mock->{$property});
    }

    public function configProvider()
    {
        return [
            'test custom type' => [
                ['type' => 'my-type'], 'type', 'my-type'
            ],
            'test custom cssClass' => [
                ['cssClass' => 'my-cssClass'], 'cssClass', 'my-cssClass form-control'
            ],
            'test custom default' => [
                ['default' => 'my-default'], 'default', 'my-default'
            ],
            'test custom description' => [
                ['description' => 'my-description'], 'description', 'my-description'
            ],
            'test custom readOnly' => [
                ['readOnly' => true], 'readOnly', true
            ],
            'test custom disabled' => [
                ['disabled' => true], 'disabled', true
            ],
            'test custom required' => [
                ['required' => true], 'required', true
            ],
            'test custom attributes' => [
                ['attributes' => ['attr-1', 'attr-2']], 'attributes', ['attr-1', 'attr-2']
            ],
        ];
    }
}
