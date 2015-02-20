<?php
/**
 * Menuitem Resource Query
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Resource;

use CommonApi\Controller\ResourceInterface;

/**
 * Menuitem Resource Query
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class MenuItem extends Base implements ResourceInterface
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

        $controller = $this->setQuery($resource_name, $page_type, $path);

        $this->resource->data = $this->runQuery($controller);

        $this->setParameters();
        $this->setModelRegistry($controller);

        if ((int)$this->resource->parameters->theme_id === 0) {
            $this->resource->parameters->theme_id = $this->default_theme_id;
        }

        $this->resource->catalog_type_id       = $this->resource->parameters->criteria_catalog_type_id;
        $this->resource->extension_instance_id = $this->resource->parameters->criteria_extension_instance_id;
        $this->resource->model_name            = $resource_name;

        return parent::getResource();
    }

    /**
     * Set Resource Menu Item Query
     *
     * @param   string $resource_name
     * @param   string $page_type
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setQuery($resource_name, $page_type, $path)
    {
//        if ($resource_name === '') {
            $model = 'Molajo//Model//Menuitem//'
                . ucfirst(strtolower($page_type))
                . '//Configuration.xml';
  //      } else {
    //        $model = 'Molajo//'
      //          . ucfirst(strtolower($resource_name))
        //        . '//Menuitem//'
          //      . ucfirst(strtolower($page_type))
            //    . '.xml';
     //   }

        $controller = $this->resource_instance->get(
            'query:///' . $model,
            array('runtime_data' => $this->runtime_data)
        );

        $prefix = $controller->getModelRegistry('primary_prefix', 'a');

        $controller->setModelRegistry('check_view_level_access', 1);
        $controller->setModelRegistry('process_events', 1);
        $controller->setModelRegistry('query_object', 'item');
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('use_special_joins', 1);

        $controller->where('column', $prefix . '.' . 'status', '>', 'integer', 0);
        $controller->where('column', $prefix . '.' . 'page_type', '=', 'string', ucfirst(strtolower($page_type)));
        $controller->where('column', $prefix . '.' . 'catalog_type_id', '=', 'integer', 11000);
        $controller->where('column', $prefix . '.' . 'catalog_type_id', '<>', 'column', $prefix . '.' . 'id');
        $controller->where('column', 'catalog.page_type', '=', 'string', $page_type);
        $controller->where('column', 'catalog.sef_request', '=', 'string', $path);

        return $controller;
    }
}
