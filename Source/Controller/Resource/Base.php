<?php
/**
 * Base Page Type Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use Exception;
use CommonApi\Exception\UnexpectedValueException;
use stdClass;

/**
 * Base Page Type Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
{
    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0
     */
    protected $runtime_data = null;

    /**
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resource_instance = null;

    /**
     * Default Theme ID
     *
     * @var    string
     * @since  1.0
     */
    protected $default_theme_id = null;

    /**
     * Home
     *
     * @var    string
     * @since  1.0
     */
    protected $home = null;

    /**
     * Method
     *
     * @var    string
     * @since  1.0
     */
    protected $method = null;

    /**
     * Action
     *
     * @var    string
     * @since  1.0
     */
    protected $action = null;

    /**
     * Action
     *
     * @var    string
     * @since  1.0
     */
    protected $special_action = null;

    /**
     * Page Type
     *
     * @var    string
     * @since  1.0
     */
    protected $page_type = null;

    /**
     * Model Type
     *
     * @var    string
     * @since  1.0
     */
    protected $model_type = null;

    /**
     * Model Name
     *
     * @var    string
     * @since  1.0
     */
    protected $model_name = null;

    /**
     * Base URL
     *
     * @var    string
     * @since  1.0
     */
    protected $base_url = null;

    /**
     * Path
     *
     * @var    string
     * @since  1.0
     */
    protected $path = null;

    /**
     * Filters
     *
     * @var    array
     * @since  1.0
     */
    protected $filters = array();

    /**
     * POST variable array
     *
     * @var    array
     * @since  1.0
     */
    protected $post_variable_array = array();

    /**
     * Source ID
     *
     * @var    string
     * @since  1.0
     */
    protected $source_id = null;

    /**
     * Resource Output
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Constructor
     *
     * @param  object $resource_instance
     * @param  object $route
     * @param  object $runtime_data
     *
     * @since  1.0
     */
    public function __construct(
        $resource_instance,
        $route,
        $runtime_data
    ) {
        $this->resource_instance = $resource_instance;
        $this->runtime_data      = $runtime_data;
        $this->setRouteInput($route);
        $this->initialiseResourceObject();
    }

    /**
     * Retrieve Resource Item
     *
     * @return  object
     * @since   1.0
     */
    public function getResource()
    {
        $this->resource = $this->sortObject($this->resource);

        return $this->resource;
    }

    /**
     * Set Route Data
     *
     * @param   object $route
     *
     * @return  $this
     * @since   1.0
     */
    protected function setRouteInput($route)
    {
        $this->default_theme_id    = $route->default_theme_id;
        $this->home                = $route->home;
        $this->method              = $route->method;
        $this->action              = $route->action;
        $this->special_action      = $route->special_action;
        $this->page_type           = ucfirst(strtolower($route->page_type));
        $this->model_type          = $route->model_type;
        $this->model_name          = $route->model_name;
        $this->base_url            = $route->base_url;
        $this->path                = trim(strtolower($route->path));
        $this->filters             = $route->filters;
        $this->post_variable_array = $route->post_variable_array;

        return $this;
    }

    /**
     * Initialize Resource Object
     *
     * @return  $this
     * @since   1.0
     */
    protected function initialiseResourceObject()
    {
        $this->resource                           = new stdClass();
        $this->resource->catalog_type_id          = null;
        $this->resource->model_name               = null;
        $this->resource->data                     = new stdClass();
        $this->resource->parameters               = array();
        $this->resource->model_registry           = array();

        return $this;
    }

    /**
     * Run Query
     *
     * @param   object $controller
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function runQuery($controller)
    {
        try {
            $results = $controller->getData();

        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        if (count($results) === 0) {
            throw new UnexpectedValueException('Resource Data not found.');
        }

        return $results;
    }

    /**
     * Set Parameters
     *
     * @return  $this
     * @since   1.0
     */
    protected function setParameters()
    {
        if (isset($this->resource->data->parameters->theme_id)
            && (int)$this->resource->data->parameters->theme_id > 0
        ) {
        } else {
            $this->resource->data->parameters->theme_id = $this->default_theme_id;
        }

        $parameters = $this->resource->data->parameters;
        unset($this->resource->data->parameters);

        $this->resource->parameters = $parameters;

        return $this;
    }

    /**
     * Set Model Registry
     *
     * @return  object
     * @since   1.0
     */
    protected function setModelRegistry($controller)
    {
        $this->resource->model_registry = $controller->getModelRegistry('*');

        return $this;
    }

    /**
     * Sort an object
     *
     * @param   object $object
     *
     * @return  object
     * @since   1.0.0
     */
    protected function sortObject($object)
    {
        $sort_array = get_object_vars($object);
        ksort($sort_array);

        $new_object = new stdClass();
        foreach ($sort_array as $key => $value) {
            if (is_object($value)) {
                $value = $this->sortObject($value);
            }
            $new_object->$key = $value;
        }

        unset($sort_array);
        unset($object);

        return $new_object;
    }
}
