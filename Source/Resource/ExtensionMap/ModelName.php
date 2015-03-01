<?php
/**
 * Model Name
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource;

use Molajo\Resource\ExtensionMap\Customfields;

/**
 * Model Name
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class ModelName extends Customfields
{
    /**
     * Process Extensions
     *
     * @param   integer $catalog_type_id
     * @param   string  $catalog_type_model_name
     * @param   string  $alias
     * @param   integer $id
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setExtensionModelName($catalog_type_id, $catalog_type_model_name, $alias, $id)
    {
        if (in_array($catalog_type_model_name, array('Resources', 'System'))) {
            $model_name = $this->setExtensionModelNameResource($alias, $catalog_type_model_name);

        } elseif ($catalog_type_id == $this->runtime_data->reference_data->catalog_type_menuitem_id) {
            $model_name = $this->setExtensionModelNameMenuitem($this->temp_page_types, $id);

        } else {
            $model_name = $this->setExtensionModelNameDefault($catalog_type_model_name, $alias);
        }

        return $model_name;
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
}
