<?php namespace PascalKleindienst\FormListGenerator\Fields;

use PascalKleindienst\FormListGenerator\Support\Config;

/**
 * Field which loads a partial or some simple HTML Content
 * @package \PascalKleindienst\FormListGenerator\Fields
 */
class PartialHTMLField extends AbstractField
{
    /**
     * @var array Contains the subheading for the section field (optional)
     */
    public $comment;

    /**
     * @var string Contains the path to the partial
     */
    public $path;

    /**
     * {@inheritDoc}
     */
    protected function registerConfigKeys()
    {
        return [ 'comment', 'path' ];
    }

    /**
     * Load a partial or some simple HTML Content
     *
     * @param array $records
     * @return string|null
     */
    public function getValue(array $records = [])
    {
        $record  = $this->getRecord($records);

        // Display a section
        if ($this->type === 'section') {
            $content = '<h2>' . $this->label . '</h2>';

            if ($this->comment) {
                $content .= '<p>' . $this->comment . '</p>';
            }

            return $content;
        } // Display a partial
        elseif ($this->type === 'partial') {
            // Replace ~ with root path
            $this->path = str_replace('~', Config::get('root'), $this->path);

            if (file_exists($this->path)) {
                $value = $record;
                include($this->path);
            }
        }
        
        return null;
    }
}
