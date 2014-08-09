<?php
/**
 * Resource Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use Exception;
use CommonApi\Exception\UnexpectedValueException;
use stdClass;

/**
 * Resource Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
{
    /**
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resource_instance = null;

    /**
     * Page Type
     *
     * @var    string
     * @since  1.0
     */
    protected $page_type = null;

    /**
     * Default Theme ID
     *
     * @var    string
     * @since  1.0
     */
    protected $default_theme_id = null;

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
     * SEF Request
     *
     * @var    string
     * @since  1.0
     */
    protected $sef_request = null;

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
     * @param  object $resource
     *
     * @since  1.0
     */
    public function __construct(
        $resource_instance,
        $resource
    ) {
        $this->resource_instance = $resource_instance;

        $this->setResourceInput($resource);
        $this->initialiseResourceObject();
    }

    /**
     * Initialize Resource Object
     *
     * @return  Base $resource
     *
     * @return  Base
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function setResourceInput($resource)
    {
        $this->default_theme_id = $resource->default_theme_id;
        $this->page_type        = ucfirst(strtolower($resource->page_type));
        $this->model_type       = $resource->model_type;
        $this->model_name       = $resource->model_name;
        $this->sef_request      = $resource->sef_request;
        $this->source_id        = $resource->source_id;

        return $this;
    }

    /**
     * Initialize Resource Object
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function initialiseResourceObject()
    {
        $this->resource                           = new stdClass();
        $this->resource->catalog_type_id          = null;
        $this->resource->criteria_catalog_type_id = null;
        $this->resource->resource_model_name      = null;
        $this->resource->data                     = new stdClass();
        $this->resource->parameters               = array();
        $this->resource->model_registry           = array();
        $this->resource->menuitem                 = new stdClass();
        $this->resource->menuitem->data           = new stdClass();
        $this->resource->menuitem->parameters     = array();
        $this->resource->menuitem->model_registry = array();

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
     * Set Resource Menu Query
     *
     * $param   array  $model_registry
     * $param   array  $parameters
     *
     * @return  $this
     * @since   1.0
     */
    protected function setResourceMenuitemParameters($model_registry, $parameters)
    {
        $parameter_keys = $this->getParameterKeys(
            $this->resource->menuitem->parameters
        );

        foreach ($model_registry['parameters'] as $registry_item) {

            $this->setResourceMenuitemParameter($parameters, $registry_item, $parameter_keys);
        }

        $this->resource->model_registry = $model_registry;

        return $this;
    }

    /**
     * Set Parameter Key and Value
     *
     * @param   array $parameters
     * @param   array $registry_item
     * @param   array $parameter_keys
     *
     * @return  Base
     * @since   1.0
     */
    protected function setResourceMenuitemParameter($parameters, $registry_item, $parameter_keys)
    {
        if (in_array($registry_item['name'], $parameter_keys)) {
            return $this;
        }

        $key = $registry_item['name'];

        if (isset($parameters->$key)) {
            $value = $parameters->$key;
        } else {
            $value = null;
        }

        $this->resource->menuitem->model_registry['parameters'][] = $registry_item;

        $this->resource->menuitem->parameters->$key = $value;

        return $this;
    }

    /**
     * Get Parameter Keys
     *
     * @param   array $parameters
     *
     * @return  array
     * @since   1.0
     */
    protected function getParameterKeys($parameters)
    {
        $parameter_keys = array();

        foreach ($parameters as $key => $value) {
            $parameter_keys[] = $key;
        }

        return $parameter_keys;
    }
}
