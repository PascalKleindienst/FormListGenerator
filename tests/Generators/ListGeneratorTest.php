<?php namespace PascalKleindienst\FormListGenerator\Generators;

use PascalKleindienst\FormListGenerator\Support\Config;

/**
 * ListGenerator Testcase
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
class ListGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected $generator;

    public function setup()
    {
        Config::set(['root' => __DIR__]);
        $this->generator = new ListGenerator('list.yaml');
    }

    public function testGetFactory()
    {
        $this->assertInstanceOf(\PascalKleindienst\FormListGenerator\Data\Column::class, $this->generator->createColumn('test', []));
    }

    public function testRender()
    {
        ob_start();
        $this->generator->render([
            ['id' => 1, 'full_name' => 'John Doe', 'age' => 42, 'create_at' => '2017-05-04'],
            ['id' => 2, 'full_name' => 'Jane Doe', 'age' => 21, 'create_at' => '2017-05-04'],
        ]);

        // remove whitespace from html content
        $from = ['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/> </s'];
        $to   = ['>',            '<',            '\\1',      '><'];
        
        $this->assertEquals(
            preg_replace($from, $to, file_get_contents(__DIR__ . '/table.html')),
            preg_replace($from, $to, ob_get_contents())
        );
        
        ob_end_clean();
    }
}
