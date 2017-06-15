<?php namespace PascalKleindienst\FormListGenerator\Support;

/**
 * Simple Config Test class
 * @package \PascalKleindienst\FormListGenerator\Support
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAndSet()
    {
        // Empty config
        $this->assertEmpty(Config::get('foo'));

        // default value
        $this->assertEquals('default', Config::get('foo', 'default'));

        // Set and get value
        Config::set(['foo' => 'bar']);
        $this->assertEquals('bar', Config::get('foo', 'default'));

        // test merge
        Config::set(['foo' => 'foobar', 'bar' => 'baz']);
        $this->assertEquals('foobar', Config::get('foo', 'default'));
        $this->assertEquals('baz', Config::get('bar', 'default'));
    }
}
