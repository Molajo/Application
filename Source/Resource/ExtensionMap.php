<?php
/**
 * Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource;

use CommonApi\Resource\MapInterface;
use Molajo\Resource\ExtensionMap\Customfields;
use stdClass;

/**
 * Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class ExtensionMap extends Customfields implements MapInterface
{
    /**
     * Catalog Types
     *
     * @return  stdClass
     * @since   1.0.0
     */
    public function createMap()
    {
        $map = $this->getCatalogTypes();

        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $x = json_encode($map, JSON_PRETTY_PRINT);
        } else {
            $x = json_encode($map);
        }

        file_put_contents($this->extensions_filename, $x);

        return $map;
    }

    /**
     * Get Catalog Types
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function getCatalogTypes()
    {
        $controller = $this->setCatalogTypesQuery();
        $results    = $this->runQuery($controller);

        return $this->processCatalogTypes($results);
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

            $extensions[$id] = $this->getExtensions($id, $model_names[$id]);
        }

        unset($catalog_types);

        $catalog_type             = new stdClass();
        $catalog_type->ids        = $ids;
        $catalog_type->names      = $names;
        $catalog_type->extensions = $extensions;

        return $catalog_type;
    }

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

            if (in_array($catalog_type_model_name, array('Resources', 'System'))) {
                $model_name = $this->setExtensionModelNameResource($alias, $catalog_type_model_name);

            } elseif ($catalog_type_id == $this->runtime_data->reference_data->catalog_type_menuitem_id) {
                $model_name = $this->setExtensionModelNameMenuitem($this->temp_page_types, $id);

            } else {
                $model_name = $this->setExtensionModelNameDefault($catalog_type_model_name, $alias);
            }

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
        $this->temp_ids        = array();
        $this->temp_names      = array();
        $this->temp_extensions = array();
        $this->temp_menus      = array();
        $this->temp_page_types = array();

        foreach ($items as $item) {

            if ($catalog_type_id == $this->runtime_data->reference_data->catalog_type_menuitem_id) {
                $name = $this->initialiseExtensionsMenuItem($item);
            } else {
                $name = $item->alias;
            }

            $this->temp_ids[$item->id] = $name;
            $this->temp_names[$name]   = $item->id;
        }

        $x                = array_unique($this->temp_menus);
        $this->temp_menus = $x;
        ksort($this->temp_ids);

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
     * @param   string $catalog_type_model_name
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setCatalogTypeModelName($catalog_type_model_name)
    {
        $catalog_type_model_name = ucfirst(strtolower($catalog_type_model_name));

        if ($catalog_type_model_name === 'Views//pages') {
            $catalog_type_model_name = 'Views//Pages';
        } elseif ($catalog_type_model_name === 'Views//templates') {
            $catalog_type_model_name = 'Views//Templates';
        } elseif ($catalog_type_model_name === 'Views//wraps') {
            $catalog_type_model_name = 'Views//Wraps';
        }

        return $catalog_type_model_name;
    }

    /**
     * Set Extension Model Name for Menu Item
     *
     * @param   string $alias
     * @param   string $catalog_type_model_name
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setExtensionModelNameResource($alias, $catalog_type_model_name)
    {
        return 'Molajo//' . $catalog_type_model_name . '//' . $alias . '//Extension.xml';
    }

    /**
     * Set Extension Model Name for Menu Item
     *
     * @param   array   $page_types
     * @param   integer $id
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setExtensionModelNameMenuitem($page_types, $id)
    {
        $pagetype = $page_types[$id];
        $pagetype = ucfirst(strtolower($pagetype));

        return 'Molajo//Model//Menuitem//' . $pagetype . '//Configuration.xml';
    }

    /**
     * Set Extension Model Name (Not Resource or Menuitem)
     *
     * @param   string $catalog_type_model_name
     * @param   string $alias
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setExtensionModelNameDefault($catalog_type_model_name, $alias)
    {
        return 'Molajo//' . $catalog_type_model_name . '//' . $alias . '//Configuration.xml';
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
        $custom_field_types = $model_registry['customfieldgroups'];

        if (is_array($custom_field_types)) {
        } else {
            $custom_field_types = array();
        }

        if (count($custom_field_types) > 0) {
            if (is_array($custom_field_types) && count($custom_field_types) > 0) {
                foreach ($custom_field_types as $group) {
                    $data->$group = $this->processCustomfieldGroup($group, $data, $model_registry);
                }
            }
        }

        return $data;
    }
}
