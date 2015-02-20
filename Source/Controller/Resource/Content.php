<?php
/**
 * Content Resource Query for Item, Update, Delete, or Edit Page Types
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Controller\ResourceInterface;

/**
 * Content Resource Query for Item, Update, Delete, or Edit Page Types
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Content extends Base implements ResourceInterface
{
    /**
     * Get Resource Data for Content
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $this->getResourceData(
            $this->resource->data->extension_instance_id,
            $this->resource->data->catalog_type_id,
            $this->model_name
        );

        return parent::getResource();
    }

    /**
     * Set Resource Content Query
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setQuery()
    {
        $model = 'Molajo//' . $this->model_name . '//Content.xml';

        $controller = $this->resource_instance->get('query:///' . $model, array('runtime_data' => $this->runtime_data));

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where('column', 'catalog.sef_request', '=', 'string', $this->path);

        return $controller;
    }
}
