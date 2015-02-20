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
     * Css String array
     *
     * @var    array
     * @since  1.0.0
     */
    protected $css = array();

    /**
     * CSS Priorities
     *
     * @var    array
     * @since  1.0.0
     */
    protected $css_priorities = array();

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
            $type = 'folder';

        } elseif (file_exists($located_path)) {
            $type = 'file';

        } else {
            return null;
        }

        $priority = '';
        if (isset($options['priority'])) {
            $priority = $options['priority'];
        }

        $mimetype = '';
        if (isset($options['mimetype'])) {
            $mimetype = $options['mimetype'];
        }

        $media = '';
        if (isset($options['media'])) {
            $media = $options['media'];
        }

        $conditional = '';
        if (isset($options['conditional'])) {
            $conditional = $options['conditional'];
        }

        $attributes = array();
        if (isset($options['attributes'])) {
            $attributes = $options['attributes'];
        }

        if ($type == 'folder') {
            $this->addCssFolder(
                $located_path,
                $priority
            );

        } else {
            $this->addCss(
                $located_path,
                $priority,
                $mimetype,
                $media,
                $conditional,
                $attributes
            );
        }

        return $this;
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
    protected function addCssFolder($file_path, $priority = 500)
    {
        $files = scandir($file_path);

        if (count($files) === 0) {
            return $this;
        }

        foreach ($files as $file) {
            if ($this->skipFile($file, 'css', $this->language_direction) === true) {
                $this->addCss($file_path . '/' . $file, $priority);
            }
        }

        return $this;
    }

    /**
     * addCss - Adds a linked stylesheet to the page
     *
     * @param   string $file_path
     * @param   int    $priority
     * @param   string $mimetype
     * @param   string $media
     * @param   string $conditional
     * @param   array  $attributes
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function addCss(
        $file_path,
        $priority = 500,
        $mimetype = 'text/css',
        $media = '',
        $conditional = '',
        $attributes = array()
    ) {
        $css = $this->css;

        foreach ($css as $item) {

            if ($item->path == $file_path
                && $item->mimetype == $mimetype
                && $item->media == $media
                && $item->conditional == $conditional
            ) {
                return $this;
            }
        }

        $temp_row = new stdClass();

        $temp_row->path        = $file_path;
        $temp_row->priority    = $priority;
        $temp_row->mimetype    = $mimetype;
        $temp_row->media       = $media;
        $temp_row->conditional = $conditional;
        $temp_row->attributes  = trim(implode(' ', $attributes));

        $css[] = $temp_row;

        $this->css = $css;

        $priorities = $this->css_priorities;

        if (in_array($priority, $priorities)) {
        } else {
            $priorities[] = $priority;
        }

        sort($priorities);

        $this->css_priorities = $priorities;

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
        $temp = $this->css;

        if (is_array($temp) && count($temp) > 0) {
        } else {
            return array();
        }

        $priorities = $this->css_priorities;
        sort($priorities);

        $query_results = array();

        foreach ($priorities as $priority) {

            foreach ($temp as $temp_row) {

                $include = false;

                if (isset($temp_row->priority)) {
                    if ($temp_row->priority == $priority) {
                        $include = true;
                    }
                }

                if ($include === false) {
                } else {
                    $temp_row->application_html5 = $this->html5;
                    $temp_row->end               = $this->line_end;
                    $temp_row->page_mimetype     = $this->mimetype;
                    $query_results[]             = $temp_row;
                }
            }
        }

        return $query_results;
    }
}
