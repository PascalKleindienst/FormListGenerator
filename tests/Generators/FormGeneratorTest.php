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
            '    <div class="form-group col-md-6">' . PHP_EOL .
            '        <label class="d-block">Test<label class="d-block  "><input type="text" name="test" value="Testing" placeholder="Some Placeholder"> Some Comment</label></label>' .
            '                    <small class="form-text text-muted">Some Description</small>'  . PHP_EOL .
            '            </div>' . PHP_EOL,
            ob_get_contents()
        );
        ob_end_clean();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderTranslated()
    {
        ob_start();
        date_default_timezone_set('Europe/Berlin');

        $this->generator->setTranslator(function ($message) {
            return 'Translated: ' . $message;
        });
        $this->generator->render(['test' => 'Testing']);
        $this->assertEquals(
            '    <div class="form-group col-md-6">' . PHP_EOL .
            '        <label class="d-block">Translated: Test<label class="d-block  "><input type="text" name="test" value="Testing" placeholder="Translated: Some Placeholder">' .
            ' Translated: Some Comment</label></label>' .
            '                    <small class="form-text text-muted">Translated: Some Description</small>'  . PHP_EOL .
            '            </div>' . PHP_EOL,
            ob_get_contents()
        );
        ob_end_clean();
    }
}
