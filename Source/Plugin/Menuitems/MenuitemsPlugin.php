<?php
/**
 * Menuitems Plugin
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Plugin\Menuitems;

use Exception;
use CommonApi\Event\SystemInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\Plugin\SystemEventPlugin;
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

        $menuitem->model->query->select(
            $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('title')
        );
        $menuitem->model->query->select(
            $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('id')
        );
        $menuitem->model->query->select(
            $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('lvl')
        );

        $menuitem->model->query->where(
            $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('status')
            . ' IN (0,1,2)'
        );
        $menuitem->model->query->where(
            $menuitem->model->database->qn('catalog.enabled')
            . ' = 1'
        );
        $menuitem->model->query->where(
            $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('catalog_type_id')
            . ' = ' . $this->runtime_data->reference_data->catalog_type_menuitem_id
        );

        $menuitem->model->query->order(
            $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('root')
            . ','
            . $menuitem->model->database->qn($menuitem->getModelRegistry('primary_prefix', 'a'))
            . '.' . $menuitem->model->database->qn('lft')
        );

        $menuitem->setModelRegistry('model_offset', 0);
        $menuitem->setModelRegistry('model_count', 99999);
        $menuitem->setModelRegistry('model_use_pagination', 0);

        try {
            $temp_row = $menuitem->getData();

        } catch (Exception $e) {
            throw new RuntimeException ($e->getMessage());
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
                for ($i = 0; $i < $lvl; $i ++) {
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
