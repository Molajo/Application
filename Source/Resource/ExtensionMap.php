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
use Molajo\Resource\ExtensionMap\CatalogTypes;
use stdClass;

/**
 * Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
final class ExtensionMap extends CatalogTypes implements MapInterface
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

        $x = json_encode($map, JSON_PRETTY_PRINT);

        file_put_contents($this->extensions_filename, $x);

        return $map;
    }
}
