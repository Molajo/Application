<?php
/**
 * Extension Resource Query for New, Create, and List Page Types
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Application\ResourceInterface;

/**
 * Extension Resource Query for New, Create, and List Page Types
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Extension extends Base implements ResourceInterface
{
    /**
     * Get Resource Data for Extension
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $model = 'Molajo//' . $this->model_type . '//' . $this->model_name . '//Extension.xml';

        $this->setQueryController($model);

        $this->setQueryControllerDefaults(
            $process_events = 1,
            $query_object = 'item',
            $get_customfields = 1,
            $use_special_joins = 1,
            $use_pagination = 0,
            $check_view_level_access = 1,
            $get_item_children = 0
        );

        $catalog_type_id = (int)$this->query->getModelRegistry('criteria_catalog_type_id', 0);
        $id              = (int)$this->query->getModelRegistry('primary_key_value', 0);

        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->query->where('column', $prefix . '.catalog_type_id', '=', 'integer', $catalog_type_id);
        $this->query->where('column', $prefix . '.id', '=', 'integer', $id);

        $this->getResourceData(
            $this->resource_output->data->id,
            $this->resource_output->data->catalog_type_id,
            $this->model_name
        );

        return parent::getResource();
    }
}
