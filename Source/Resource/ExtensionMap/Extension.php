<?php
/**
 * Extension
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource;

use stdClass;

/**
 * Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class Extension extends ModelName
{
     /**
     * Retrieve Extensions for a specific Catalog Type
     *
     * @param   int    $catalog_type_id
     * @param   string $catalog_type_model_name
     *
     * @return  array|stdClass
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getExtensions($catalog_type_id, $catalog_type_model_name)
    {
        $controller = $this->setExtensionsQuery($catalog_type_id);
        $items      = $this->runQuery($controller);

        if (is_array($items) && count($items) > 0) {
        } else {
            return array();
        }

        return $this->processExtensions($items, $catalog_type_id, $catalog_type_model_name);
    }

    /**
     * Process Extensions
     *
     * @param   array   $items
     * @param   integer $catalog_type_id
     * @param   string  $catalog_type_model_name
     *
     * @return  array|stdClass
     * @since   1.0.0
     */
    protected function processExtensions($items, $catalog_type_id, $catalog_type_model_name)
    {
        $this->initialiseExtensions($items, $catalog_type_id);

        $catalog_type_model_name = $this->setCatalogTypeModelName($catalog_type_model_name);

        foreach ($this->temp_ids as $id => $alias) {

            $alias = ucfirst(strtolower($alias));

            $model_name = $this->setExtensionModelName($catalog_type_id, $catalog_type_model_name, $alias, $id);

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
        $this->temp_names[$name]   = $item->id;

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

    /**
     * Retrieve specific Extension Information
     *
     * @param   int    $id
     * @param   string $model_name
     *
     * @return  object
     * @since   1.0.0
     */
    protected function getExtension($id, $model_name)
    {
        $controller = $this->setExtensionQuery($id, $model_name);

        $data       = $this->runQuery($controller);
        if ($data === null) {
            return new stdClass();
        }

        $model_registry = $controller->getModelRegistry('*');

        return $this->processExtension($data, $model_registry);
    }

    /**
     * Retrieve specific Extension Information
     *
     * @param   object $data
     * @param   array  $model_registry
     *
     * @return  object
     * @since   1.0.0
     */
    protected function processExtension($data, array $model_registry)
    {
        $custom_field_types = $this->processExtensionCustomFieldTypes($model_registry);

        if (count($custom_field_types) > 0) {
            if (is_array($custom_field_types) && count($custom_field_types) > 0) {
                foreach ($custom_field_types as $group) {
                    $data->$group = $this->processCustomfieldGroup($group, $data, $model_registry);
                }
            }
        }

        return $data;
    }

    /**
     * Process Extension Custom Field Types
     *
     * @param   array  $model_registry
     *
     * @return  array
     * @since   1.0.0
     */
    protected function processExtensionCustomFieldTypes(array $model_registry)
    {
        $custom_field_types = $model_registry['customfieldgroups'];

        if (is_array($custom_field_types)) {
        } else {
            $custom_field_types = array();
        }

        return $custom_field_types;
    }
}
