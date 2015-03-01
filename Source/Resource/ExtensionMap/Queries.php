<?php
/**
 * Queries for Extension Map Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

use Exception;
use CommonApi\Exception\RuntimeException;

/**
 * Queries for Extension Map Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
abstract class Queries
{
    /**
     * Stores an array of key/value runtime_data settings
     *
     * @var    object
     * @since  1.0.0
     */
    protected $runtime_data = null;

    /**
     * Resource Instance
     *
     * @var    object
     * @since  1.0.0
     */
    protected $resource;

    /**
     * Extensions Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $extensions_filename;

    /**
     * Extensions Filename
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_ids = array();

    /**
     * Extensions Filename
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_names = array();

    /**
     * Extensions Filename
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_extensions = array();

    /**
     * Extensions Filename
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_menus = array();

    /**
     * Extensions Filename
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_page_types = array();

    /**
     * Constructor
     *
     * @param  object $resource
     * @param  object $runtime_data
     * @param  string $extensions_filename
     *
     * @since  1.0.0
     */
    public function __construct(
        $resource,
        $runtime_data,
        $extensions_filename = null
    ) {
        $this->resource            = $resource;
        $this->runtime_data        = $runtime_data;
        $this->extensions_filename = $extensions_filename;
    }

    /**
     * Set Catalog Types Query
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setCatalogTypesQuery()
    {
        $controller = $this->resource->get(
            'query:///Molajo//Model//Datasource//CatalogTypes.xml',
            array('Runtimedata' => $this->runtime_data)
        );

        $this->setStandardQueryValues($controller);

        $this->setCatalogTypesSql($controller);

        return $controller;
    }

    /**
     * Set Catalog Types Query Sql
     *
     * @param   object $controller
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setCatalogTypesSql($controller)
    {
        $prefix = $controller->getModelRegistry('prefix', 'a');

        $catalog_id_list = $this->setCatalogTypesQueryString();

        $controller->select('*');
        $controller->from('#__catalog_types', 'a');
        $controller->where('column', $prefix . '.id', 'IN', 'integer', $catalog_id_list, 'OR');
        $controller->where('column', $prefix . '.model_type', '=', 'string', 'Resource', 'OR');

        return $this;
    }

    /**
     * Set Catalog Types Query String
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setCatalogTypesQueryString()
    {
        return (int)$this->runtime_data->reference_data->catalog_type_plugin_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_theme_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_page_view_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_template_view_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_wrap_view_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_menuitem_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_resource_id;
    }

    /**
     * Retrieve System Extensions for a specific Catalog Type
     *
     * @param   integer $catalog_type_id
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setExtensionsQuery($catalog_type_id)
    {
        $controller = $this->resource->get(
            'query:///Molajo//Model//Datasource//ExtensionInstances.xml',
            array('Runtimedata' => $this->runtime_data)
        );

        $this->setExtensionsQueryValues($controller);

        $this->setExtensionsSql($controller, $catalog_type_id);

        return $controller;
    }

    /**
     * Set Extensions Query Values
     *
     * @param   object $controller
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsQueryValues($controller)
    {
        $application_id = $this->runtime_data->application->id;
        $site_id        = $this->runtime_data->site->id;

        $this->setStandardQueryValues($controller);
        $controller->setModelRegistry('application_id', $application_id);
        $controller->setModelRegistry('site_id', $site_id);
        $controller->setModelRegistry('use_special_joins', 1);

        return $this;
    }

    /**
     * Set Extensions Query Sql
     *
     * @param   object  $controller
     * @param   integer $catalog_type_id
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsSql($controller, $catalog_type_id)
    {
        $prefix = $controller->getModelRegistry('primary_prefix', 'a');
        $cat_id = $prefix . '.' . 'catalog_type_id';

        $controller->select($prefix . '.' . 'id');
        $controller->select($prefix . '.' . 'alias');
        $controller->select($prefix . '.' . 'menu');
        $controller->select($prefix . '.' . 'path');
        $controller->select($prefix . '.' . 'page_type');

        $controller->where('column', $cat_id, '=', 'integer', $catalog_type_id);
        $controller->where('column', $prefix . '.' . 'id', '<>', 'column', $cat_id);
        $controller->where('column', $prefix . '.' . 'status', '>', 'integer', ' 0 ');

        $controller->orderBy($prefix . '.' . 'alias');

        return $this;
    }

    /**
     * Set Extension Query
     *
     * @param   int    $id
     * @param   string $model_name
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setExtensionQuery($id, $model_name)
    {
        $controller = $this->resource->get(
            'query:///' . $model_name,
            array('Runtimedata' => $this->runtime_data)
        );

        $this->setStandardQueryValues($controller);
        $controller->setModelRegistry('get_customfields', 1);
        $controller->setModelRegistry('primary_key_value', $id);
        $controller->setModelRegistry('query_object', 'item');

        $this->setExtensionSql($controller, $id);

        return $controller;
    }

    /**
     * Set Extension Query Sql
     *
     * @param   object  $controller
     * @param   integer $id
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionSql($controller, $id)
    {

        $application_id = $this->runtime_data->application->id;
        $site_id        = $this->runtime_data->site->id;

        $controller->setModelRegistry('application_id', $application_id);
        $controller->setModelRegistry('site_id', $site_id);
        $prefix = $controller->getModelRegistry('primary_prefix', 'a');

        $controller->where('column', $prefix . '.' . 'id', '=', 'integer', (int)$id);

        return $this;
    }

    /**
     * Set Standard Query Values
     *
     * @param   object $controller
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setStandardQueryValues($controller)
    {
        $controller->setModelRegistry('check_view_level_access', 0);
        $controller->setModelRegistry('process_events', 0);
        $controller->setModelRegistry('query_object', 'list');
        $controller->setModelRegistry('use_pagination', 0);
        $controller->setModelRegistry('process_events', 0);
        $controller->setModelRegistry('get_customfields', 0);

        return $this;
    }
    
    /**
     * Run Query
     *
     * @param   object $controller
     *
     * @return  mixed
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function runQuery($controller)
    {
        $controller->setSql();

        try {
            return $controller->getData();

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
