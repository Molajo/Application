<?php
/**
 * Css Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\AdapterInterface;
use stdClass;

/**
 * Css Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class Css extends Assets implements AdapterInterface
{
    /**
     * CSS Files array
     *
     * @var    array
     * @since  1.0.0
     */
    protected $css_files = array();

    /**
     * Language Direction
     *
     * @var    string
     * @since  1.0.0
     */
    protected $language_direction;

    /**
     * HTML5
     *
     * @var    string
     * @since  1.0.0
     */
    protected $html5;

    /**
     * Line End
     *
     * @var    string
     * @since  1.0.0
     */
    protected $line_end;

    /**
     * Mime Type
     *
     * @var    string
     * @since  1.0.0
     */
    protected $mimetype;

    /**
     * Constructor
     *
     * @param  string $base_path
     * @param  array  $resource_map
     * @param  array  $namespace_prefixes
     * @param  array  $valid_file_extensions
     * @param  array  $cache_callbacks
     * @param  array  $handler_options
     *
     * @since  1.0.0
     */
    public function __construct(
        $base_path = null,
        array $resource_map = array(),
        array $namespace_prefixes = array(),
        array $valid_file_extensions = array(),
        array $cache_callbacks = array(),
        array $handler_options = array()
    ) {
        parent::__construct(
            $base_path,
            $resource_map,
            $namespace_prefixes,
            $valid_file_extensions,
            $cache_callbacks
        );

        $this->language_direction = $handler_options['language_direction'];
        $this->html5              = $handler_options['html5'];
        $this->line_end           = $handler_options['line_end'];
        $this->mimetype           = $handler_options['mimetype'];
    }

    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $scheme
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function handlePath($scheme, $located_path, array $options = array())
    {
        if (is_dir($located_path)) {
            $this->addCssFolder($located_path, $options);

        } elseif (file_exists($located_path)) {
            $this->addCssFile($located_path, $options);
        }

        return $this;
    }

    /**
     * Retrieve a collection of a specific handler
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function getCollection($scheme, array $options = array())
    {
        return $this->getAssetPriorities($this->css_files);
    }

    /**
     * addCssFolder - Loads the CSS files located within the identified folder
     *
     * @param   string  $file_path
     * @param   integer $priority
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addCssFolder($file_path, $options)
    {
        $files = scandir($file_path);

        if (count($files) === 0) {
            return $this;
        }

        foreach ($files as $file) {
            $this->addCssFile($file_path . '/' . $file, $options);
        }

        return $this;
    }

    /**
     * addCss - Adds a single linked stylesheet to the page array
     *
     * @param   string $file_path
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addCssFile($file_path, array $options = array())
    {
        if ($this->skipFile($file_path, 'css', $this->language_direction) === true) {
            return $this;
        }

        if ($this->skipDuplicateFile($file_path, $this->css_files) === true) {
            return $this;
        }

        $row = $this->setCssRow($file_path, $options);

        $this->css_files[] = $row;

        return $this;
    }
}
