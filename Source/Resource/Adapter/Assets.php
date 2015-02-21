<?php
/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use stdClass;

/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
abstract class Assets extends AbstractAdapter
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
                'defer'    => FILTER_SANITIZE_STRING,
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
            $this->addAssetFolder($located_path, $options);

        } elseif (file_exists($located_path)) {
            $this->addAssetFile($located_path, $options);

        } else {
            $this->addAssetString($options);
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
        $priorities = $this->getAssetPriorities();

        $priority_order = array();

        foreach ($priorities as $priority) {
            foreach ($this->asset_array as $row) {
                if ($row->priority === $priority) {
                    $priority_order[] = $row;
                }
            }
        }

        return $priority_order;
    }

    /**
     * addAssetFolder - Loads the CSS files located within the identified folder
     *
     * @param   string  $file_path
     * @param   integer $priority
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addAssetFolder($file_path, $options)
    {
        $files = scandir($file_path);

        if (count($files) === 0) {
            return $this;
        }

        foreach ($files as $file) {
            $this->addAssetFile($file_path . '/' . $file, $options);
        }

        return $this;
    }

    /**
     * Add Asset Filename to Page Array
     *
     * @param   string $file_path
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addAssetFile($file_path, array $options = array())
    {
        if (is_file($file_path) === false) {
            return $this;
        }

        if ($this->skipFile($file_path, $this->language_direction) === true) {
            return $this;
        }

        if ($this->skipDuplicateFile($file_path) === true) {
            return $this;
        }

        $row = $this->setAssetRow($file_path, $options);

        $this->asset_array[] = $row;

        return $this;
    }

    /**
     * Add Asset Filename to the page array
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addAssetString(array $options = array())
    {
        if (isset($options['css_string'])) {
        } else {
            return $this;
        }

        $css_string = $options['css_string'];
        unset($options['css_string']);

        $row = $this->setAssetRow($css_string, $options);

        $this->asset_array[] = $row;

        return $this;
    }

    /**
     * Perform file checks for inclusion
     *
     * @param   string $file
     * @param   string $language_direction
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function skipFile($file, $language_direction)
    {
        $options = $this->setMethodOptions($file, $language_direction);

        foreach ($this->methods as $method) {

            if ($this->$method($options) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Load options into an array
     *
     * @param   string $file
     * @param   string $language_direction
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setMethodOptions($file, $language_direction)
    {
        $pathinfo = pathinfo($file);

        $options                       = array();
        $options['file']               = $file;
        $options['filename']           = $pathinfo['filename'];
        $options['extension']          = $pathinfo['extension'];
        $options['language_direction'] = $language_direction;

        return $options;
    }

    /**
     * Verify if file is '.' or '..'
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyDotFile(array $options = array())
    {
        if ($options['filename'] == '.' || $options['filename'] == '..') {
            return true;
        }

        return false;
    }

    /**
     * Verify Language Directional File
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyLanguageDirectionalFile(array $options = array())
    {
        $test = substr($options['filename'], 0, 3);

        if (in_array($test, array('ltr', 'rtl'))) {

            if ($test === $options['language_direction']) {
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Verify Skip File
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifySkipFile(array $options = array())
    {
        if (strtolower(substr($options['filename'], 0, 4)) == 'hold') {
            return true;
        }

        return false;
    }

    /**
     * Verify name is actually a file
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyNotFile(array $options = array())
    {
        if (is_file($options['file']) === true) {
        } else {
            return true;
        }

        return false;
    }

    /**
     * Verify File Extension
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyNotFileExtension(array $options = array())
    {
        if ($options['extension'] === $this->asset_type) {
            return false;
        }

        return true;
    }

    /**
     * Skip file if it has already been defined to page array
     *
     * @param   string $file_path
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function skipDuplicateFile($file_path)
    {
        if (count($this->asset_array) === 0) {
            return false;
        }

        foreach ($this->asset_array as $existing) {
            if ($existing->path_or_string === $file_path) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create a row containing the CSS information
     *
     * @param   string $path_or_string
     * @param   array  $options
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setAssetRow($path_or_string, array $options = array())
    {
        $row                 = new stdClass();
        $row->path_or_string = $path_or_string;

        foreach ($this->asset_options as $name => $filter) {

            if (isset($options[$name])) {
                $value = $options[$name];
            } else {
                $value = null;
            }

            $row->$name = $this->filterOptionValue($value, $filter);
        }

        return $row;
    }

    /**
     * Filter Option Value
     *
     * @param   mixed  $value
     * @param   string $filter
     *
     * @return  string
     * @since   1.0.0
     */
    protected function filterOptionValue($value, $filter)
    {
        if ($filter === 'array') {

            if (is_array($value)) {
                $value = trim(implode(' ', $value));
                return (string)$value;

            } else {
                return '';
            }
        }

        return filter_var($value, $filter);
    }

    /**
     * Develop a unique list of priorities in priority order
     *
     * @return  array
     * @since   1.0.0
     */
    protected function getAssetPriorities()
    {
        if (is_array($this->asset_array) && count($this->asset_array) > 0) {
        } else {
            return array();
        }

        $priorities = array();

        foreach ($this->asset_array as $row) {
            $priorities[] = $row->priority;
        }

        array_unique($priorities);

        sort($priorities);

        return $priorities;
    }
}
