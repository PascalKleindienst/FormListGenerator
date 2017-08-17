<?php namespace PascalKleindienst\FormListGenerator\Generators;

use PascalKleindienst\FormListGenerator\Support\Config;

/**
 * FormGenerator Testcase
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
class FormGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected $generator;

    public function setup()
    {
        Config::set(['root' => __DIR__]);
        $this->generator = new FormGenerator('form.yaml');
    }

    /**
     * @param  mixed $obj
     * @param  string $propertyName
     * @return mixed
     */
    public function getProperty($obj, $propertyName)
    {
        $reflector = new \ReflectionClass($obj);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
 
        return $property->getValue($obj);
    }

    public function mockView($generator)
    {
        $generator->view = $this->getMock('stdClass', ['render']);
        $generator->view->expects($this->any())
                ->method('render')
                ->will($this->returnValue(''));

        return $generator;
    }

    public function testGetFactory()
    {
        $this->assertInstanceOf(\PascalKleindienst\FormListGenerator\Fields\FieldFactory::class, $this->generator->getFactory());
    }

    public function testRemoveField()
    {
        // Mock View Class so we do not output anything
        $generator = $this->mockView($this->generator);

        // Remove Fields
        $generator->removeField('test');
        
        // Check if removed
        $this->assertCount(2, $this->getProperty($generator, 'config')['fields']);
        
        $generator->render([]);
        $this->assertCount(1, $this->getProperty($generator, 'config')['fields']);
        $this->assertArrayHasKey('testSize', $this->getProperty($generator, 'config')['fields']);
    }

    public function testAddField()
    {
        // Mock View Class so we do not output anything
        $generator = $this->mockView($this->generator);

        // Add Fields
        $generator->addField('adding', ['type' => 'text', 'label' => 'Test Label']);
        
        // Check if added
        $this->assertCount(2, $this->getProperty($generator, 'config')['fields']);
        
        $generator->render([]);
        $this->assertCount(3, $this->getProperty($generator, 'config')['fields']);
        $this->assertArrayHasKey('adding', $this->getProperty($generator, 'config')['fields']);
    }

    public function testAddFieldType()
    {
        // Mock View Class so we do not output anything
        $generator = $this->mockView($this->generator);

        // Add Fields
        $generator->addFieldType('testing', \PascalKleindienst\FormListGenerator\Fields\Field::class);
        
        // Check if added
        $this->assertCount(1, $this->getProperty($generator, 'customFields'));
        $this->assertArrayHasKey('testing', $this->getProperty($generator, 'customFields'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddFieldTypeThrowsExceptionIfFieldDoesNotInheritAbstractField()
    {
        // Mock View Class so we do not output anything
        $generator = $this->mockView($this->generator);

        // Add Fields
        $generator->addFieldType('test', \std::class);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender()
    {
        ob_start();
        date_default_timezone_set('Europe/Berlin');
        $this->generator->render(['test' => 'Testing']);
        $this->assertEquals(
            '    <div class="form-group col-md-12">' . PHP_EOL .
            '        <label class="d-block">Test<label class="d-block  "><input type="text" name="test" value="Testing" placeholder="Some Placeholder"> Some Comment</label></label>' .
            '                    <small class="form-text text-muted">Some Description</small>'  . PHP_EOL .
            '                    </div>' . PHP_EOL .
            '    <div class="form-group col-md-6">' . PHP_EOL .
            '        <label class="d-block">Size<select name="testSize" class=" form-control"><option value="a">b</option></select></label>                    </div>' . PHP_EOL,
            ob_get_contents()
        );
        ob_end_clean();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithErrors()
    {
        ob_start();
        date_default_timezone_set('Europe/Berlin');
        $this->generator->render(['test' => 'Testing'], ['test' => 'some error']);
        $this->assertEquals(
            '    <div class="form-group col-md-12 has-danger">' . PHP_EOL .
            '        <label class="d-block">Test<label class="d-block  "><input type="text" name="test" value="Testing" placeholder="Some Placeholder"> Some Comment</label></label>' .
            '                    <small class="form-text text-muted">Some Description</small>' . PHP_EOL .
            '                            <span class="form-control-feedback">' . PHP_EOL .
            '            some error            </span>' . PHP_EOL .
            '            </div>' . PHP_EOL .
            '    <div class="form-group col-md-6">' . PHP_EOL .
            '        <label class="d-block">Size<select name="testSize" class=" form-control"><option value="a">b</option></select></label>                    </div>' . PHP_EOL,
            ob_get_contents()
        );
        ob_end_clean();
    }

    public function testRenderTranslated()
    {
        ob_start();
        date_default_timezone_set('Europe/Berlin');

        $this->generator->setTranslator(function ($message) {
            return 'Translated: ' . $message;
        });
        $this->generator->render(['test' => 'Testing']);
        $this->assertEquals(
            '    <div class="form-group col-md-12">' . PHP_EOL .
            '        <label class="d-block">Translated: Test<label class="d-block  "><input type="text" name="test" value="Testing" placeholder="Translated: Some Placeholder"> ' .
            'Translated: Some Comment</label></label>                    <small class="form-text text-muted">Translated: Some Description</small>' . PHP_EOL .
            '                    </div>' . PHP_EOL .
            '    <div class="form-group col-md-6">' . PHP_EOL .
            '        <label class="d-block">Translated: Size<select name="testSize" class=" form-control"><option value="a">Translated: b</option></select></label>' .
            '                    </div>' . PHP_EOL,
            ob_get_contents()
        );
        ob_end_clean();
    }
}
