<?php
/**
 * Grid Menuitem Resource Query
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Exception\UnexpectedValueException;

/**
 * Grid Menuitem Resource Query
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class GridMenuitem extends ListPageType
{
    /**
     * Retrieve Resource Item
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceGridMenuitem()
    {
        $controller     = $this->setResourceGridMenuitemQuery();
        $data           = $this->runQuery($controller);
        $parameters = $data->parameters;
        unset($data->parameters);
        $model_registry = $controller->getModelRegistry('*');

        $this->setResourceMenuitemParameters($model_registry, $parameters);

        return $this;
    }

    /**
     * Set Resource Menu Query
     *
     * @return  object
     * @since   1.0
     */
    protected function setResourceGridMenuitemQuery()
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

        return $controller;
    }
}
