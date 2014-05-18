<?php
/**
 * Resource Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use stdClass;
use CommonApi\Controller\ResourceInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\Exception\UnexpectedValueException;
use Exception;

/**
 * Resource Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ResourceController implements ResourceInterface
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
     * @param  string $default_theme_id
     * @param  string $page_type
     * @param  string $model_type
     * @param  string $model_name
     * @param  string $sef_request
     * @param  string $source_id
     *
     * @since  1.0
     */
    public function __construct(
        $resource_instance,
        $default_theme_id,
        $page_type,
        $model_type,
        $model_name,
        $sef_request,
        $source_id
    ) {
        $this->resource_instance = $resource_instance;
        $this->default_theme_id  = $default_theme_id;
        $this->page_type         = ucfirst(strtolower($page_type));
        $this->model_type        = $model_type;
        $this->model_name        = $model_name;
        $this->sef_request       = $sef_request;
        $this->source_id         = $source_id;

        $this->resource                           = new stdClass();
        $this->resource->catalog_type_id          = null;
        $this->resource->criteria_catalog_type_id = null;
        $this->resource->resource_model_name      = null;
        $this->resource->data                     = new stdClass();
        $this->resource->parameters               = array();
        $this->resource->model_registry           = array();
        $this->resource->menuitem->data           = new stdClass();
        $this->resource->menuitem->parameters     = array();
        $this->resource->menuitem->model_registry = array();
    }

    /**
     * Get Resource Data for Route
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    public function getResource()
    {
        if ($this->page_type == 'Dashboard') {
            return $this;
        }

        if ($this->page_type == 'Item' || $this->page_type == 'Edit' || $this->page_type == 'Delete') {
            $this->getResourceItem();

        } elseif ($this->page_type == 'List') {
            $this->getResourceList();

        } else {
            $this->getResourceMenu();
        }

        return $this->resource;
    }

    /**
     * Retrieve Resource Item
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceItem()
    {
        if ($this->model_type == 'Resource') {
            $model = 'Molajo//' . $this->model_name . '//Configuration.xml';
        } else {
            $model = 'Molajo//' . $this->sef_request . '//Configuration.xml';
        }

        $resource = $this->resource_instance->get('query:///' . $model);

        $resource->setModelRegistry('check_view_level_access', 1);
        $resource->setModelRegistry('process_events', 1);
        $resource->setModelRegistry('query_object', 'item');
        $resource->setModelRegistry('get_customfields', 1);
        $resource->setModelRegistry('use_special_joins', 1);

        $resource->where(
            'column',
            $resource->getModelRegistry('primary_prefix', 'a')
            . '.'
            . $resource->getModelRegistry('primary_key', 'id'),
            '=',
            'integer',
            (int)$this->source_id
        );

        try {
            $item = $resource->getData();

            $model_registry = $resource->getModelRegistry('*');

        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        if (count($item) == 0) {
            throw new UnexpectedValueException('Resource Item not found.');
        }

        if (isset($item->parameters->theme_id) && (int)$item->parameters->theme_id > 0) {
        } else {
            $item->parameters->theme_id = $this->default_theme_id;
        }

        $parameters = $item->parameters;
        unset($item->parameters);

        $this->resource->data           = $item;
        $this->resource->parameters     = $parameters;
        $this->resource->model_registry = $model_registry;

        return $this;
    }

    /**
     * Retrieve Resource List
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceList()
    {
        $this->resource_instance->where(
            'column',
            $this->resource_instance->getModelRegistry('primary_prefix', 'a')
            . '.'
            . $this->resource_instance->getModelRegistry('primary_key', 'id'),
            '=',
            'integer',
            (int)$this->source_id
        );

        $this->resource_instance->setModelRegistry('query_object', 'list');

        try {
            $item = $this->resource_instance->getData();
        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        if (count($item) == 0) {
            throw new UnexpectedValueException('Resource Data not found.');
        }

        $this->resource->data = new stdClass();

        foreach (\get_object_vars($item) as $key => $value) {
            $this->resource->data->$key = $value;
        }

        return $this;
    }

    /**
     * Retrieve Menu Item Data
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceMenu()
    {
        if ($this->page_type == 'Dashboard') {
            return $this;
        }

        $x        = explode('/', $this->sef_request);
        $resource = ucfirst(strtolower($x[0]));
        $model    = 'Molajo//' . $resource . '//Menuitem//' . $this->page_type . '.xml';

        $controller = $this->resource_instance->get('query:///' . $model);

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where(
            'column',
            $controller->getModelRegistry('primary_prefix', 'a') . '.' . 'id',
            '=',
            'integer',
            (int)$this->source_id
        );

        try {
            $menuitem = $controller->getData();

        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        if (count($menuitem) == 0) {
            throw new UnexpectedValueException('Resource Plugin: Resource Menu Item not found.');
        }

        if (isset($menuitem->parameters->theme_id)
            && (int)$menuitem->parameters->theme_id > 0
        ) {
        } else {
            $menuitem->parameters->theme_id = $this->default_theme_id;
        }

        $this->resource->menuitem = new stdClass();
        $parameters               = $menuitem->parameters;

        unset($menuitem->parameters);
        $this->resource->menuitem->data           = $menuitem;
        $this->resource->menuitem->parameters     = $parameters;
        $this->resource->menuitem->model_registry = $controller->getModelRegistry('*');


        if ($this->page_type == 'Configuration') {
            $this->getResourceGridMenuItem();
            $this->getResourceExtension();

        } elseif ($this->page_type == 'New') {
            $this->getResourceExtension();

        } else {

            $this->resource->criteria_catalog_type_id = $this->resource->menuitem->data->catalog_type_id;
            $this->resource->resource_model_name      = ucfirst($this->resource->menuitem->data->alias);
        }

        return $this;
    }

    /**
     * Retrieve Resource Menu Item
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceGridMenuItem()
    {
        $x        = explode('/', $this->sef_request);
        $resource = ucfirst(strtolower($x[0]));

        $controller = $this->resource_instance->get('query:///Molajo//' . $resource . '//Menuitem//Grid.xml');

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where(
            'column',
            $controller->getModelRegistry('primary_prefix', 'a') . '.' . 'alias',
            '=',
            'string',
            $this->resource->menuitem->data->path
        );

        $controller->where(
            'column',
            $controller->getModelRegistry('primary_prefix', 'a') . '.' . 'status',
            '>',
            'integer',
            0
        );

        try {
            $grid_menuitem = $controller->getData();

            $grid_menuitem_parameters = $grid_menuitem->parameters;
            unset($grid_menuitem->parameters);

            $grid_menuitem_model_registry = $controller->getModelRegistry('*');

        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        if (count($grid_menuitem) == 0) {
            throw new UnexpectedValueException(
                'Resource Plugin getResourceGridMenuItem: Resource Grid Menu Item not found.'
            );
        }

        $parameter_keys = array();
        foreach ($this->resource->menuitem->parameters as $key => $value) {
            $parameter_keys[] = $key;
        }

        foreach ($grid_menuitem_model_registry['parameters'] as $registry_item) {

            if (in_array($registry_item['name'], $parameter_keys)) {
            } else {
                $key = $registry_item['name'];

                if (isset($grid_menuitem_parameters->$key)) {
                    $value = $grid_menuitem_parameters->$key;
                } else {
                    $value = null;
                }
                $this->resource->menuitem->model_registry['parameters'][]
                    = $registry_item;

                $this->resource->menuitem->parameters->$key
                    = $value;
            }
        }

        return $this;
    }

    /**
     * Retrieve Resource Extension Item
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceExtension()
    {
        $resource_model_name = ucfirst($this->resource->menuitem->data->path);
        $model               = 'Molajo//' . $resource_model_name . '//Extension.xml';
        $controller          = $this->resource_instance->get('query:///' . $model);

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        try {
            $data = $controller->getData();

            $parameters = $data->parameters;
            unset($data->parameters);

            $model_registry = $controller->getModelRegistry('*');

        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        $parameter_keys = array();
        foreach ($this->resource->menuitem->parameters as $key => $value) {
            $parameter_keys[] = $key;
        }

        foreach ($model_registry['parameters'] as $registry_item) {

            if (in_array($registry_item['name'], $parameter_keys)) {
            } else {
                $key = $registry_item['name'];

                if (isset($parameters->$key)) {
                    $value = $parameters->$key;
                } else {
                    $value = null;
                }

                $this->resource->menuitem->model_registry["parameters"][]
                    = $registry_item;

                $this->resource->menuitem->parameters->$key
                    = $value;
            }
        }

        $this->resource->data                     = $data;
        $this->resource->parameters               = $parameters;
        $this->resource->model_registry           = $model_registry;
        $this->resource->catalog_type_id          = $data->catalog_type_id;
        $this->resource->criteria_catalog_type_id = $data->catalog_type_id;
        $this->resource->resource_model_name      = $resource_model_name;

        return $this;
    }
}
