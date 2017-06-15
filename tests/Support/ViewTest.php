<?php namespace PascalKleindienst\FormListGenerator\Support;

/**
 * Simple View Test class
 * @package \PascalKleindienst\FormListGenerator\Support
 */
class ViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PascalKleindienst\FormListGenerator\Support\View
     */
    protected $view;

    public function setup()
    {
        $this->view = new View(realpath(__DIR__ . '/../views/'));
    }
    
    public function testGetPath()
    {
        $this->assertEquals(realpath(__DIR__ . '/../views/'), $this->view->getPath());
    }

    public function testRenderWithData()
    {
        ob_start();
        $this->view->render('test', ['foo' => 'bar']);
        $this->assertEquals('Test bar', ob_get_contents());
        ob_end_clean();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRenderWithWrongFile()
    {
        $this->view->render('doesnotexist');
    }
}
