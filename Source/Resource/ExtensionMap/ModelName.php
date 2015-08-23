<?php
/**
 * Model Name
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

/**
 * Model Name
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
abstract class ModelName extends Base
{
    /**
     * Process Extensions
     *
     * @param   integer $catalog_type_id
     * @param   string  $namespace
     * @param   integer $id
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setExtensionModelName($catalog_type_id, $namespace, $id)
    {
        if ((int)$catalog_type_id === 12000) {
            $model_name = $this->setExtensionModelNameResource($namespace);

        } elseif ($catalog_type_id == $this->runtime_data->reference_data->catalog_type_menuitem_id) {
            $model_name = $this->setExtensionModelNameMenuitem($id);

        } else {
            $model_name = $this->setExtensionModelNameDefault($namespace);
        }

        return $model_name;
    }

    /**
     * Set Extension Model Name for Menu Item
     *
     * @param   string $namespace
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setExtensionModelNameResource($namespace)
    {
        return $namespace . '//Extension.xml';
    }

    /**
     * Set Extension Model Name for Menu Item
     *
     * @param   integer $id
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setExtensionModelNameMenuitem($id)
    {
        $pagetype = $this->temp_page_types[$id];
        $pagetype = ucfirst(strtolower($pagetype));

        return 'Molajo//Model//Menuitem//' . $pagetype . '//Configuration.xml';
    }

    /**
     * Set Extension Model Name (Not Resource or Menuitem)
     *
     * @param   string $namespace
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setExtensionModelNameDefault($namespace)
    {
        return $namespace . '//Configuration.xml';
    }
}
