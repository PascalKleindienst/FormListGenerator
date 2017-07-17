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

    public function testGetFactory()
    {
        $this->assertInstanceOf(\PascalKleindienst\FormListGenerator\Fields\FieldFactory::class, $this->generator->getFactory());
    }

    public function testRender()
    {
        ob_start();
        $this->generator->render(['test' => 'Testing']);
        $this->assertEquals(
            '    <div class="form-group col-md-6">' . PHP_EOL .
            '        <label class="d-block">Test<input type="text" name="test" value="Testing" class=" form-control"></label>' .
            '                    <small class="form-text text-muted">Some Description</small>'  . PHP_EOL .
            '            </div>' . PHP_EOL,
            ob_get_contents()
        );
        ob_end_clean();
    }
}
