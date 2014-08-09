<?php
/**
 * Menuitem Resource Query
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use stdClass;
use CommonApi\Exception\UnexpectedValueException;

/**
 * Menuitem Resource Query
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class MenuitemPageType extends GridMenuitem
{
    /**
     * Retrieve Menu Item Data
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceMenu()
    {
        if ($this->page_type === 'Dashboard') {
            return $this;
        }

        $this->setResourceMenuitemObject();

        if ($this->page_type === 'Configuration') {
            $this->getResourceGridMenuitem();
            $this->getResourceExtension();

        } elseif ($this->page_type === 'New') {
            $this->getResourceExtension();

        } else {
            $this->resource->criteria_catalog_type_id = $this->resource->menuitem->data->catalog_type_id;
            $this->resource->resource_model_name      = ucfirst($this->resource->menuitem->data->alias);
        }

        return $this;
    }

    /**
     * Set Resource Menu Parameters
     *
     * $param   object  $data
     *
     * @return  $this
     * @since   1.0
     */
    protected function setResourceMenuitemObject()
    {
        $controller = $this->setResourceMenuQuery();

        $data = $this->runQuery($controller);

        $parameters = $this->setResourceMenuitemObjectParameters($data);

        unset($data->parameters);

        $this->resource->menuitem->data           = $data;
        $this->resource->menuitem->parameters     = $parameters;
        $this->resource->menuitem->model_registry = $controller->getModelRegistry('*');

        return $this;
    }

    /**
     * Set Resource Menu Query
     *
     * @return  object
     * @since   1.0
     */
    protected function setResourceMenuQuery()
    {
        $x        = explode('/', $this->sef_request);
        $resource = ucfirst(strtolower($x[0]));
        $model    = 'Molajo//' . $resource . '//Menuitem//' . $this->page_type . '.xml';

        $controller = $this->resource_instance->get('query:///' . $model);
        $prefix = $controller->getModelRegistry('primary_prefix', 'a');

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where('column', $prefix . '.' . 'id', '=', 'integer', (int)$this->source_id);

        return $controller;
    }

    /**
     * Set Resource Menu Parameters
     *
     * $param   object  $data
     *
     * @return  array
     * @since   1.0
     */
    protected function setResourceMenuitemObjectParameters($data)
    {
        if (isset($data->parameters->theme_id)
            && (int)$data->parameters->theme_id > 0
        ) {
        } else {
            $data->parameters->theme_id = $this->default_theme_id;
        }

        $this->resource->menuitem = new stdClass();
        $parameters               = $data->parameters;

        return $parameters;
    }
}
