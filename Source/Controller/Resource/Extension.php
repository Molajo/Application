<?php
/**
 * Extension Resource Query for New, Create, and List Page Types
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Controller\ResourceInterface;

/**
 * Extension Resource Query for New, Create, and List Page Types
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Extension extends Base implements ResourceInterface
{
    /**
     * Get Resource Data for Extension
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $this->getResourceData(
            $this->resource->data->id,
            $this->resource->data->catalog_type_id,
            $this->model_name
        );

        return parent::getResource();
    }

    /**
     * Set Resource Extension Query
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setQuery()
    {
        $model      = 'Molajo//' . $this->model_name . '//Extension.xml';
        $controller = $this->resource_instance->get('query:///' . $model, array('runtime_data' => $this->runtime_data));

        $catalog_type_id = (int)$controller->getModelRegistry('criteria_catalog_type_id', 0);
        $id              = (int)$controller->getModelRegistry('primary_key_value', 0);

        $prefix = $controller->getModelRegistry('prefix', 'a');

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where('column', $prefix . '.catalog_type_id', '=', 'integer', $catalog_type_id);
        $controller->where('column', $prefix . '.id', '=', 'integer', $id);

        return $controller;
    }
}
