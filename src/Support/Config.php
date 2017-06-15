<?php namespace PascalKleindienst\FormListGenerator\Support;

/**
 * Simple Config class
 * @package \PascalKleindienst\FormListGenerator\Support
 */
class Config
{
    /**
     * @var array
     */
    static protected $items = [];

    /**
     * Set config items
     *
     * @param array $items
     * @return void
     */
    public static function set(array $items = [])
    {
        self::$items = array_merge(self::$items, $items);
    }

    /**
     * Get a config item if it exists or a default value if not
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (array_key_exists($key, self::$items)) {
            return self::$items[$key];
        }

        return $default;
    }
}
