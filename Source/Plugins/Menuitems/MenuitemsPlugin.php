<?php
/**
 * Menuitems Plugin
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Plugins\Menuitems;

use Exception;
use CommonApi\Event\SystemInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\Plugins\SystemEventPlugin;
use stdClass;

/**
 * Menuitems Plugin
 *
 * @package  Molajo
 * @license  http://www.opensource.org/licenses/mit-license.html MIT License
 * @since    1.0
 */
class MenuitemsPlugin extends SystemEventPlugin implements SystemInterface
{
    /**
     * Generates list of Menus and Menuitems for use in Datalists
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeExecute()
    {
        $menuitem = $this->resource->get('query:///Molajo//Model//Datasource//Menuitem.xml');

        $menuitem->setModelRegistry('check_view_level_access', 1);
        $menuitem->setModelRegistry('process_events', 0);
        $menuitem->setModelRegistry('query_object', 'list');
        $menuitem->setModelRegistry('get_customfields', 0);
        $menuitem->setModelRegistry('use_special_joins', 1);

        $menuitem->select($menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'title');
        $menuitem->select($menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'id');
        $menuitem->select($menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'lvl');

        $menuitem->where(
            'column',
            $menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'status',
            'IN',
            'integer',
            '0,1,2'
        );

        $menuitem->where(
            'column',
            'catalog' . '.' . 'enabled',
            '=',
            'integer',
            '1'
        );

        $menuitem->where(
            'column',
            $menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'catalog_type_id',
            '=',
            'integer',
            (int)$this->runtime_data->reference_data->catalog_type_menuitem_id
        );

        $menuitem->orderBy($menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'root', 'ASC');
        $menuitem->orderBy($menuitem->getModelRegistry('primary_prefix', 'a') . '.' . 'lft', 'ASC');
        $menuitem->setModelRegistry('model_use_pagination', 0);

        try {
            $temp_row = $menuitem->getData();

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        if (count($temp_row) == 0) {
            $this->plugin_data->datalists->menuitems = array();
            return $this;
        }

        $menuitem = array();
        foreach ($temp_row as $item) {
            $temp_row = new stdClass();

            $name = $item->title;
            $lvl  = (int)$item->lvl - 1;

            if ($lvl > 0) {
                for ($i = 0; $i < $lvl; $i++) {
                    $name = ' ..' . $name;
                }
            }

            $temp_row->id    = $item->id;
            $temp_row->value = trim($name);

            $menuitem[] = $temp_row;
        }

        $this->plugin_data->datalists->menuitems = $menuitem;

        return $this;
    }
}
