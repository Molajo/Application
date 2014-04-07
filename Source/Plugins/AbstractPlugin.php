<?php
/**
 * Abstract Plugin
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugins;

use CommonApi\Exception\RuntimeException;
use Exception;
use stdClass;

/**
 * Abstract Plugin - Overrides Abstract Plugin in Event Package
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
abstract class AbstractPlugin
{
    /**
     * Plugin Name
     *
     * @var    string
     * @since  1.0
     */
    protected $plugin_name = null;

    /**
     * Event Name
     *
     * @var    string
     * @since  1.0
     */
    protected $event_name = null;

    /**
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Fieldhandler
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler = null;

    /**
     * Date Controller
     *
     * @var    object  CommonApi\Controller\DateInterface
     * @since  1.0
     */
    protected $date_controller = null;

    /**
     * Url Controller
     *
     * @var    object  CommonApi\Controller\UrlInterface
     * @since  1.0
     */
    protected $url_controller = null;

    /**
     * Language Instance
     *
     * @var    object CommonApi\Language\LanguageInterface
     * @since  1.0
     */
    protected $language_controller;

    /**
     * Authorisation Controller
     *
     * @var    object  CommonApi\Authorisation\AuthorisationInterface
     * @since  1.0
     */
    protected $authorisation_controller;

    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0
     */
    protected $runtime_data = null;

    /**
     * Plugin Data
     *
     * @var    object
     * @since  1.0
     */
    protected $plugin_data = null;

    /**
     * Parameters
     *
     * @var    object
     * @since  1.0
     */
    protected $parameters = null;

    /**
     * Query
     *
     * @var    object
     * @since  1.0
     */
    protected $query = null;

    /**
     * Model Registry
     *
     * @var    object
     * @since  1.0
     */
    protected $model_registry = null;

    /**
     * Query Results
     *
     * @var    array
     * @since  1.0
     */
    protected $query_results = array();

    /**
     * Query Results
     *
     * @var    object
     * @since  1.0
     */
    protected $row = null;

    /**
     * View Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_view = null;

    /**
     * Page Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_page = null;

    /**
     * Constructor
     *
     * @param  string  $plugin_name
     * @param  string  $event_name
     * @param  array   $data
     *
     * @since  1.0
     */
    public function __construct(
        $plugin_name = '',
        $event_name = '',
        array $data = array()
    ) {
        $this->plugin_name = $plugin_name;
        $this->event_name  = $event_name;

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Get the current value (or default) of the specified property
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }

        $results = array();

        $results['runtime_data']   = $this->runtime_data;
        $results['plugin_data']    = $this->plugin_data;
        $results['parameters']     = $this->parameters;
        $results['query']          = $this->query;
        $results['model_registry'] = $this->model_registry;
        $results['query_results']  = $this->query_results;
        $results['row']            = $this->row;
        $results['rendered_page']  = $this->rendered_page;
        $results['rendered_view']  = $this->rendered_view;

        return $results;
    }

    /**
     * Get Field Definition for specific Field Name
     *
     * @param   string     $name
     * @param   null|mixed $default
     *
     * @return  mixed
     * @since   1.0
     */
    public function getField($name, $default = null)
    {
        if (isset($this->model_registry->field->$name)) {
        } else {
            $this->model_registry->field->$name = $default;
        }

        return $this->row->$name;
    }

    /**
     * Retrieve Fields for a specified Data Type
     *
     * @param   string $type
     *
     * @return  array
     * @since   1.0
     */
    public function getFieldsByType($type)
    {
        $results = array();

        if (isset($this->model_registry['fields'])) {
        } else {
            return array();
        }

        foreach ($this->model_registry['fields'] as $field) {
            if ($field['type'] == $type) {
                $results[] = $field;
            }
        }

        return $results;
    }

    /**
     * getFieldValue retrieves the actual field value from the 'normal' or special field
     *
     * @param   object $field
     *
     * @return  null|mixed
     * @since   1.0
     */
    public function getFieldValue($field)
    {
        if (isset($field['as_name'])) {
            if ($field['as_name'] == '') {
                $name = $field['name'];
            } else {
                $name = $field['as_name'];
            }
        } else {
            $name = $field['name'];
        }

        if (isset($this->row->$name)) {
            return $this->row->$name;

        } elseif (isset($field['default'])) {
            return $field['default'];
        }

        return null;
    }

    /**
     * setField adds a field to the 'normal' or special field group
     *
     * @param   $field
     * @param   $new_field_name
     * @param   $value
     *
     * @return  $this
     * @since   1.0
     */
    public function setField($field, $new_field_name, $value)
    {
        if (is_object($this->row)) {
        } else {
            $this->row = new stdClass();
        }

        $this->row->$new_field_name = $value;

        if (is_array($this->model_registry['fields'])) {
        } else {
            $this->model_registry['fields'] = array();
        }

        if (isset($this->model_registry['fields'])) {
            foreach ($this->model_registry['fields'] as $field) {
                if ($field['type'] == $new_field_name) {
                    return $this;
                }
            }
        }

        $temp                             = $field;
        $temp['name']                     = $new_field_name;
        $temp['calculated']               = 1;
        $this->model_registry['fields'][] = $temp;

        return $this;
    }

    /**
     * saveForeignKeyValue
     *
     * @param   $new_field_name
     * @param   $value
     *
     * @return void
     * @since   1.0
     */
    public function saveForeignKeyValue($new_field_name, $value)
    {
        if (is_object($this->row)) {
        } else {
            $this->row = new stdClass();
        }

        if (isset($this->row->$new_field_name)) {
            return;
        }

        $this->row->$new_field_name = $value;

        return;
    }

    /**
     * Filter Input
     *
     * @param   string $key
     * @param   mixed  $value
     * @param   string $filter
     * @param   array  $filter_options
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function filter($key, $value = null, $filter, $filter_options = array())
    {
        try {
            $value = $this->fieldhandler->filter($key, $value, $filter, $filter_options);

        } catch (Exception $e) {
            throw new RuntimeException
            ('Request: Filter class Failed for Key: ' . $key . ' Filter: ' . $filter . ' ' . $e->getMessage());
        }

        return $value;
    }
}
