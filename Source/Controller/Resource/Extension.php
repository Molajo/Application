<?php
/**
 * Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Exception\UnexpectedValueException;

/**
 * Dispatcher
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Extension extends Base
{
    /**
     * Retrieve Resource Extension Item
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceExtension()
    {
        $controller = $this->setExtensionItemQuery();

        $data = $this->runQuery($controller);

        $parameters = $data->parameters;
        unset($data->parameters);

        $model_registry = $controller->getModelRegistry('*');

        $this->setResourceMenuitemParameters($model_registry, $parameters);

        $this->resource->data                     = $data;
        $this->resource->parameters               = $parameters;
        $this->resource->model_registry           = $model_registry;
        $this->resource->catalog_type_id          = $data->catalog_type_id;
        $this->resource->criteria_catalog_type_id = $data->catalog_type_id;
        $this->resource->resource_model_name      = ucfirst($this->resource->menuitem->data->path);

        return $this;
    }

    /**
     * Set Resource Menu Query
     *
     * @return  object
     * @since   1.0
     */
    protected function setExtensionItemQuery()
    {
        $resource_model_name = ucfirst($this->resource->menuitem->data->path);
        $model               = 'Molajo//' . $resource_model_name . '//Extension.xml';
        $controller          = $this->resource_instance->get('query:///' . $model);

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        return $controller;
    }
}
