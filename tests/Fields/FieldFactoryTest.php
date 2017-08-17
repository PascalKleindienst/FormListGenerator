<?php namespace PascalKleindienst\FormListGenerator\Fields;

/**
 * FieldFactory Test Class
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class FieldFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PascalKleindienst\FormListGenerator\Fields\FieldFactory
     */
    protected $factory;

    /**
     * Setup field factory
     *
     * @return void
     */
    public function setup()
    {
        $this->factory = new FieldFactory();
    }

    public function testConstructor()
    {
        $factory = new FieldFactory(['testing' => Field::class]);
        
        $this->assertCount(1, $factory->customFields);
        $this->assertArrayHasKey('testing', $factory->customFields);
    }

    public function testCreateDefaultField()
    {
        $this->assertInstanceOf(
            Field::class,
            $this->factory->create('default-name', [])
        );
    }

    public function testCreateRadioCheckboxList()
    {
        $this->assertInstanceOf(
            RadioCheckboxList::class,
            $this->factory->create('radio-list-name', ['type' => 'radio'])
        );

        $this->assertInstanceOf(
            RadioCheckboxList::class,
            $this->factory->create('checkbox-list-name', ['type' => 'checkboxlist'])
        );
    }

    public function testCreatePartialSection()
    {
        $this->assertInstanceOf(
            PartialHTMLField::class,
            $this->factory->create('section-name', ['type' => 'section'])
        );

        $this->assertInstanceOf(
            PartialHTMLField::class,
            $this->factory->create('partial-name', ['type' => 'partial'])
        );
    }

    /**
     * @dependsOn testConstructor
     */
    public function testCreateCustomField()
    {
        $factory = new FieldFactory(['testing' => PartialHTMLField::class]);

        $this->assertInstanceOf(
            PartialHTMLField::class,
            $factory->create('custom-name', ['type' => 'testing'])
        );
    }
}
