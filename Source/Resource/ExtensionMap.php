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
use stdClass;

/**
 * Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class ExtensionMap extends Extension implements MapInterface
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
