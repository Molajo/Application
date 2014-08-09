<?php
/**
 * Resource Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Exception\UnexpectedValueException;

/**
 * Resource Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ItemPageType extends Extension
{
    /**
     * Retrieve Resource Item
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceItem()
    {
        $controller = $this->setResourceItemQuery();

        $this->resource->data = $this->runQuery($controller);
        $this->setResourceItemParameters();
        $this->resource->model_registry = $controller->getModelRegistry('*');

        return $this;
    }

    /**
     * Set Resource Menu Query
     *
     * @return  object
     * @since   1.0
     */
    protected function setResourceItemQuery()
    {
        if ($this->model_type === 'Resource') {
            $model = 'Molajo//' . $this->model_name . '//Configuration.xml';
        } else {
            $model = 'Molajo//' . $this->sef_request . '//Configuration.xml';
        }

        $controller = $this->resource_instance->get('query:///' . $model);

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where(
            'column',
            $controller->getModelRegistry('primary_prefix', 'a')
            . '.'
            . $controller->getModelRegistry('primary_key', 'id'),
            '=',
            'integer',
            (int)$this->source_id
        );

        return $controller;
    }

    /**
     * Set Resource Menu Query
     *
     * @return  $this
     * @since   1.0
     */
    protected function setResourceItemParameters()
    {
        if (isset($this->resource->data->parameters->theme_id)
            && (int)$this->resource->data->theme_id > 0
        ) {
        } else {
            $this->resource->data->parameters->theme_id = $this->default_theme_id;
        }

        $parameters = $this->resource->data->parameters;
        unset($this->resource->data->parameters);

        $this->resource->parameters = $parameters;

        return $this;
    }
}
