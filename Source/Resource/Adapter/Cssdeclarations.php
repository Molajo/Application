<?php
/**
 * Css Declarations Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use stdClass;
use CommonApi\Resource\AdapterInterface;

/**
 * Css Declarations Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class CssDeclarations extends Assets implements AdapterInterface
{
    /**
     * Css Declarations
     *
     * @var    array
     * @since  1.0.0
     */
    protected $css_strings = array();

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
     * Mimetype
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
            $valid_file_extensions
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
        if (isset($options['css_string'])) {
        } else {
            return $this;
        }

        $css_string = $options['css_string'];
        unset($options['css_string']);

        $this->addCssString($css_string, $options);

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
     * addCssString Adds a single Css Stylesheet String to Page rarray
     *
     * @param   string $css_string
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addCssString($css_string, array $options = array())
    {
        if ($this->skipDuplicateFile($css_string, $this->css_strings) === true) {
            return $this;
        }

        $row = $this->setCssRow($css_string, $options);

        $this->css_strings[] = $row;

        return $this;
    }
}
