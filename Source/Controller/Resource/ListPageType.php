<?php
/**
 * Resource Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use stdClass;
use CommonApi\Exception\UnexpectedValueException;

/**
 * Resource Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ListPageType extends ItemPageType
{
    /**
     * Retrieve Resource List
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getResourceList()
    {
        $controller = $this->setResourceListQuery();
        $data       = $this->runQuery($controller);

        $this->resource->data = new stdClass();

        foreach (\get_object_vars($data) as $key => $value) {
            $this->resource->data->$key = $value;
        }

        $this->resource->model_registry = $controller->getModelRegistry('*');

        return $this;
    }

    /**
     * Retrieve Resource List
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function setResourceListQuery()
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

        return $this->resource_instance;
    }
}
