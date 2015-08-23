<?php
/**
 * Extensions
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

use stdClass;

/**
 * Extensions
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
abstract class Extensions extends Extension
{
    /**
     * Retrieve Extensions for a specific Catalog Type
     *
     * @param   int    $catalog_type_id
     *
     * @return  array|stdClass
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getExtensions($catalog_type_id)
    {
        $this->setExtensionsQuery($catalog_type_id);

        $items = $this->runQuery();

        if (is_array($items) && count($items) > 0) {
        } else {
            return array();
        }

        return $this->processExtensions($items, $catalog_type_id);
    }


    /**
     * Retrieve System Extensions for a specific Catalog Type
     *
     * @param   integer $catalog_type_id
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsQuery($catalog_type_id)
    {
        $this->setQueryController('Molajo//Model//Datasource//ExtensionInstances.xml');

        $this->setExtensionsQueryValues();

        $this->setExtensionsSql($catalog_type_id);

        return $this;
    }

    /**
     * Set Extensions Query Values
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsQueryValues()
    {
        $this->setQueryControllerDefaults(
            $process_events = 0,
            $query_object = 'list',
            $get_customfields = 0,
            $use_special_joins = 0,
            $use_pagination = 0,
            $check_view_level_access = 0,
            $get_item_children = 0
        );

        return $this;
    }

    /**
     * Set Extensions Query Sql
     *
     * @param   integer $catalog_type_id
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsSql($catalog_type_id)
    {
        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->query->select($prefix . '.' . 'id');
        $this->query->select($prefix . '.' . 'alias');
        $this->query->select($prefix . '.' . 'menu');
        $this->query->select($prefix . '.' . 'namespace');
        $this->query->select($prefix . '.' . 'path');
        $this->query->select($prefix . '.' . 'page_type');

        $this->query->where('column', $prefix . '.' . 'catalog_type_id', '=', 'integer', $catalog_type_id);
        $this->query->where('column', $prefix . '.' . 'id', '<>', 'column', $prefix . '.' . 'catalog_type_id');

        $this->query->orderBy($prefix . '.' . 'alias');

        return $this;
    }

    /**
     * Process Extensions
     *
     * @param   array   $items
     * @param   integer $catalog_type_id
     *
     * @return  array|stdClass
     * @since   1.0.0
     */
    protected function processExtensions($items, $catalog_type_id)
    {
        $this->initialiseExtensions($items, $catalog_type_id);

        foreach ($this->temp_namespaces as $id => $namespace) {

            $model_name = $this->setExtensionModelName($catalog_type_id, $namespace, $id);

            $this->temp_extensions[$id] = $this->getExtension($id, $model_name);
        }

        return $this->setExtensions();
    }

    /**
     * Set Extensions Results
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setExtensions()
    {
        $temp             = new stdClass();
        $temp->ids        = $this->temp_ids;
        $temp->names      = $this->temp_names;
        $temp->namespaces = $this->temp_namespaces;
        $temp->extensions = $this->temp_extensions;
        $temp->menus      = $this->temp_menus;

        return $temp;
    }

    /**
     * Initialise Extensions
     *
     * @param   array   $items
     * @param   integer $catalog_type_id
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function initialiseExtensions($items, $catalog_type_id)
    {
        $this->initialiseExtensionArrays();

        foreach ($items as $item) {
            $this->initialiseExtensionItem($catalog_type_id, $item);
        }

        $x                = array_unique($this->temp_menus);
        $this->temp_menus = $x;
        ksort($this->temp_ids);

        return $this;
    }

    /**
     * Initialise Extension Item
     *
     * @param   integer $catalog_type_id
     * @param   object  $item
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function initialiseExtensionItem($catalog_type_id, $item)
    {
        if ($catalog_type_id == $this->runtime_data->reference_data->catalog_type_menuitem_id) {
            $name = $this->initialiseExtensionsMenuItem($item);
        } else {
            $name = $item->alias;
        }

        $this->temp_ids[$item->id] = $name;

        if (isset($this->temp_names[$name])) {
            $hold = $this->temp_names[$name];
        } else {
            $hold = array();
        }

        $hold[]                  = $item->id;
        $this->temp_names[$name] = $hold;

        $namespace = str_replace('\\', '//', $item->namespace);
        $this->temp_namespaces[$item->id] = $namespace;

        return $this;
    }

    /**
     * Initialise Extension Array
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function initialiseExtensionArrays()
    {
        $this->temp_ids        = array();
        $this->temp_names      = array();
        $this->temp_namespaces = array();
        $this->temp_extensions = array();
        $this->temp_menus      = array();
        $this->temp_page_types = array();

        return $this;
    }

    /**
     * Initialize Extension Name for Menu Item
     *
     * @param   object $item
     *
     * @return  string
     * @since   1.0.0
     */
    protected function initialiseExtensionsMenuItem($item)
    {
        $this->temp_menus[] = $item->menu;

        if ($item->path === '') {
            $name = $item->alias;
        } else {
            $name = $item->path . '/' . $item->alias;
        }

        $this->temp_page_types[$item->id] = $item->page_type;

        return $name;
    }
}
