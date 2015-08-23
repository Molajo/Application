<?php
/**
 * Base Page Type Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Fieldhandler\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;
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
     * Query Usage Trait
     *
     * @var     object  CommonApi\Query\QueryUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Query\QueryUsageTrait;

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
    protected $resource_output = null;

    /**
     * Constructor
     *
     * @param  QueryInterface        $resource
     * @param  FieldhandlerInterface $fieldhandler
     * @param  object                $runtime_data
     * @param  object                $route
     *
     * @since  1.0
     */
    public function __construct(
        QueryInterface $resource,
        FieldhandlerInterface $fieldhandler,
        $runtime_data,
        $route
    ) {
        $this->resource     = $resource;
        $this->fieldhandler = $fieldhandler;
        $this->runtime_data = $runtime_data;

        $this->setRouteInput($route);
        $this->initialiseResourceObject();
    }

    /**
     * Get Resource Data for Content
     *
     * @param   integer $extension_instance_id
     * @param   integer $catalog_type_id
     * @param   string  $model_name
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResourceData($extension_instance_id, $catalog_type_id, $model_name)
    {
        $this->resource_output->data = $this->runQuery();
        $this->model_registry        = $this->query->getModelRegistry();

        $this->setParameters();

        $this->resource_output->model_registry        = $this->model_registry;
        $this->resource_output->extension_instance_id = $extension_instance_id;
        $this->resource_output->catalog_type_id       = $catalog_type_id;
        $this->resource_output->model_name            = $model_name;

        return $this;
    }

    /**
     * Retrieve Resource Item
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $this->resource_output = $this->sortObject($this->resource_output);

        return $this->resource_output;
    }

    /**
     * Set Route Data
     *
     * @param   object $route
     *
     * @return  $this
     * @since   1.0.0
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
     * @since   1.0.0
     */
    protected function initialiseResourceObject()
    {
        $this->resource_output                  = new stdClass();
        $this->resource_output->catalog_type_id = null;
        $this->resource_output->model_name      = null;
        $this->resource_output->data            = new stdClass();
        $this->resource_output->parameters      = array();
        $this->resource_output->model_registry  = array();

        return $this;
    }

    /**
     * Set Parameters
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setParameters()
    {
        if (isset($this->resource_output->data->parameters)) {
            $parameters = $this->resource_output->data->parameters;
            unset($this->resource_output->data->parameters);

        } else {
            $parameters = new stdClass();
        }

        if (isset($parameters->theme_id) && (int)$parameters->theme_id > 0) {
        } else {
            $parameters->theme_id = $this->default_theme_id;
        }

        $this->resource_output->parameters = $parameters;

        return $this;
    }
}
