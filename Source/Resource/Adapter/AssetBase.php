<?php
/**
 * Asset Base Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

/**
 * Asset Base Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
abstract class AssetBase extends AbstractAdapter
{
    /**
     * Asset Array
     *
     * @var    array
     * @since  1.0.0
     */
    protected $asset_array = array();

    /**
     * Asset Type
     *
     * @var    string
     * @since  1.0.0
     */
    protected $asset_type = null;

    /**
     * Asset Option by Type
     *
     * @var    array
     * @since  1.0.0
     */
    protected $asset_options_by_type
        = array(
            'css' => array(
                'priority'    => FILTER_SANITIZE_NUMBER_INT,
                'mimetype'    => FILTER_SANITIZE_STRING,
                'media'       => FILTER_SANITIZE_STRING,
                'conditional' => FILTER_SANITIZE_STRING,
                'attributes'  => 'array'
            ),
            'js'  => array(
                'priority' => FILTER_SANITIZE_NUMBER_INT,
                'mimetype' => FILTER_SANITIZE_STRING,
                'defer'    => FILTER_SANITIZE_NUMBER_INT,
                'async'    => FILTER_SANITIZE_STRING
            )
        );

    /**
     * Asset Options
     *
     * @var    array
     * @since  1.0.0
     */
    protected $asset_options = array();

    /**
     * Skip File Methods
     *
     * @var    array
     * @since  1.0.0
     */
    protected $methods
        = array(
            'verifyDotFile',
            'verifyLanguageDirectionalFile',
            'verifySkipFile',
            'verifyNotFile',
            'verifyNotFileExtension'
        );

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
            $valid_file_extensions
        );

        $this->setClassProperties($handler_options);
    }

    /**
     * Set Class Properties
     *
     * @param   array $handler_options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setClassProperties(array $handler_options = array())
    {
        $method = get_called_class();

        $this->asset_type = substr(strtolower($method), 0, 3);

        if ($this->asset_type === 'css') {
            $this->asset_options = $this->asset_options_by_type['css'];
        } else {
            $this->asset_options = $this->asset_options_by_type['js'];
        }

        $this->language_direction = $handler_options['language_direction'];
        $this->html5              = $handler_options['html5'];
        $this->line_end           = $handler_options['line_end'];
        $this->mimetype           = $handler_options['mimetype'];

        return $this;
    }
}
