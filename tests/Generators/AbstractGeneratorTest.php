<?php namespace PascalKleindienst\FormListGenerator\Generators;

use PascalKleindienst\FormListGenerator\Support\View;

/**
 * AbstractGenerator Testcase
 * @package \PascalKleindienst\FormListGenerator\Generators
 */
class AbstractGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorWithoutConfig()
    {
        $stub = $this->getMockForAbstractClass(AbstractGenerator::class);
        $this->assertInstanceOf(View::class, $stub->view);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithNonExistingConfigFile()
    {
        $this->getMockForAbstractClass(AbstractGenerator::class, ['notfound.yaml']);
    }

    /**
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testConstructorWithInvalidYamlConfigFile()
    {
        \PascalKleindienst\FormListGenerator\Support\Config::set(['root' => __DIR__]);
        $this->getMockForAbstractClass(AbstractGenerator::class, ['invalid.yaml']);
    }

    /**
     * @dependsOn testConstructorWithoutConfig
     */
    public function testConstructorWithValidConfig()
    {
        \PascalKleindienst\FormListGenerator\Support\Config::set(['root' => __DIR__]);
        $stub = $this->getMockForAbstractClass(AbstractGenerator::class, ['config.yaml']);
        $this->assertEquals(__DIR__ . '/views', $stub->view->getPath());
    }
}