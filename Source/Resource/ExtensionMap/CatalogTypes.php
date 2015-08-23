<?php
/**
 * Catalog Types
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

use stdClass;

/**
 * Catalog Types
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
abstract class CatalogTypes extends Extensions
{
    /**
     * Get Catalog Types
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function getCatalogTypes()
    {
        $this->setCatalogTypesQuery();

        $results = $this->runQuery();

        return $this->processCatalogTypes($results);
    }

    /**
     * Set Catalog Types Query
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setCatalogTypesQuery()
    {
        $this->setQueryController('Molajo//Model//Datasource//CatalogTypes.xml');

        $this->setQueryControllerDefaults(
            $process_events = 0,
            $query_object = 'list',
            $get_customfields = 0,
            $use_special_joins = 0,
            $use_pagination = 0,
            $check_view_level_access = 0,
            $get_item_children = 0
        );

        $this->setCatalogTypesSql();

        return $this;
    }

    /**
     * Set Catalog Types Query Sql
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setCatalogTypesSql()
    {
        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $catalog_id_list = $this->setCatalogTypesQueryString();

        $this->query->where('column', $prefix . '.id', 'IN', 'integer', $catalog_id_list, 'OR');
        $this->query->where('column', $prefix . '.model_type', '=', 'string', 'Resource', 'OR');

        return $this;
    }

    /**
     * Process Catalog Types
     *
     * @param   $catalog_types  array
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function processCatalogTypes(array $catalog_types)
    {
        $names       = array();
        $ids         = array();
        $model_names = array();
        $extensions  = array();

        foreach ($catalog_types as $type) {

            $ids[$type->id]         = $type->title;
            $names[$type->title]    = $type->id;
            $model_names[$type->id] = $type->model_name;
            $id                     = $type->id;

            $extensions[$id] = $this->getExtensions($id);
        }

        return $this->setCatalogTypeObject($ids, $names, $extensions);
    }

    /**
     * Set Catalog Type Object
     *
     * @param   $ids         array
     * @param   $names       array
     * @param   $extensions  array
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setCatalogTypeObject(array $ids, array $names, array $extensions)
    {
        $catalog_type             = new stdClass();
        $catalog_type->ids        = $ids;
        $catalog_type->names      = $names;
        $catalog_type->extensions = $extensions;

        return $catalog_type;
    }
}
