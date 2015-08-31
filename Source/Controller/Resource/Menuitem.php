<?php
/**
 * Menuitem Resource Query
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Application\ResourceInterface;

/**
 * Menuitem Resource Query
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
final class MenuItem extends Base implements ResourceInterface
{
    /**
     * Get Resource for Menu Item
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $page_type     = strtolower($this->page_type);
        $path          = strtolower($this->path);
        $resource_name = $path;
        $remove        = strlen($resource_name) - strlen($page_type) - 1;

        if (substr($resource_name, $remove + 1, strlen($page_type)) === $page_type) {
            $resource_name = substr($resource_name, 0, $remove);
        }

        $this->setQuery($page_type, $path);

        $this->getResourceData(
            $this->resource_output->data->id,
            $this->resource_output->data->catalog_type_id,
            $this->model_name
        );

        return $this->processQueryOutput($resource_name);
    }

    /**
     * Get Query for Menu Item
     *
     * @param   string $page_type
     * @param   string $path
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setQuery($page_type, $path)
    {
        $this->setQueryController('Molajo//Model//Menuitem//' . ucfirst($page_type) . '//Configuration.xml');

        $this->setQueryControllerDefaults(
            $process_events = 1,
            $query_object = 'item',
            $get_customfields = 1,
            $use_special_joins = 1,
            $use_pagination = 0,
            $check_view_level_access = 1,
            $get_item_children = 0
        );

        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->query->where('column', $prefix . '.' . 'status', '>', 'integer', 0);
        $this->query->where('column', $prefix . '.' . 'page_type', '=', 'string', ucfirst($page_type));
        $this->query->where('column', $prefix . '.' . 'catalog_type_id', '=', 'integer', 11000);
        $this->query->where('column', $prefix . '.' . 'catalog_type_id', '<>', 'column', $prefix . '.' . 'id');
        $this->query->where('column', 'catalog.page_type', '=', 'string', $page_type);
        $this->query->where('column', 'catalog.sef_request', '=', 'string', $path);

        return $this;
    }

    /**
     * Process Query Output
     *
     * @param   string $resource_name
     *
     * @return  object
     * @since   1.0.0
     */
    public function processQueryOutput($resource_name)
    {
        if ((int)$this->resource_output->parameters->theme_id === 0) {
            $this->resource_output->parameters->theme_id = $this->default_theme_id;
        }

        $this->resource_output->catalog_type_id = $this->resource_output->parameters->criteria_catalog_type_id;
//        $this->resource_output->extension_instance_id
//                                                = $this->resource_output->parameters->criteria_extension_instance_id;
        $this->resource_output->model_name      = $resource_name;

        return parent::getResource();
    }
}
