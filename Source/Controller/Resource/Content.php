<?php
/**
 * Content Resource Query for Item, Update, Delete, or Edit Page Types
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Application\ResourceInterface;

/**
 * Content Resource Query for Item, Update, Delete, or Edit Page Types
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Content extends Base implements ResourceInterface
{
    /**
     * Get Resource Data for Content
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $model_name = 'Molajo//' . $this->model_type . '//' . $this->model_name . '//Content.xml';

        $this->setQueryController($model_name);

        $this->setQueryControllerDefaults(
            $process_events = 1,
            $query_object = 'item',
            $get_customfields = 1,
            $use_special_joins = 1,
            $use_pagination = 0,
            $check_view_level_access = 1,
            $get_item_children = 0
        );

        $this->query->where('column', 'catalog.sef_request', '=', 'string', $this->path);

        $this->getResourceData(
            $this->resource_output->data->extension_instance_id,
            $this->resource_output->data->catalog_type_id,
            $this->model_name
        );

        $this->resource_output->catalog_type_id = $this->resource_output->data->catalog_type_id;

        return parent::getResource();
    }
}
