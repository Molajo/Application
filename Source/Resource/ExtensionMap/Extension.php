<?php
/**
 * Extension Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

use stdClass;

/**
 * Extension Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
abstract class Extension extends ModelName
{
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
        $this->setExtensionQuery($id, $model_name);

        $data = $this->runQuery();
        if ($data === null) {
            return new stdClass();
        }

        $model_registry = $this->setModelRegistry();

        $extension      = $this->setStandardFields($data, $model_registry);

        return $this->setCustomFields($extension, $data, $model_registry);
    }

    /**
     * Set Extension Query
     *
     * @param   int    $id
     * @param   string $model_name
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionQuery($id, $model_name)
    {
        $this->setQueryController($model_name);

        $this->setQueryControllerDefaults(
            $process_events = 0,
            $query_object = 'item',
            $get_customfields = 1,
            $use_special_joins = 1,
            $use_pagination = 0,
            $check_view_level_access = 0,
            $get_item_children = 0
        );

        $this->query->setModelRegistry('primary_key_value', $id);

        $this->setExtensionSql($id);

        return $this;
    }

    /**
     * Set Extension Query Sql
     *
     * @param   integer $id
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionSql($id)
    {
        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->query->where('column', $prefix . '.' . 'id', '=', 'integer', (int)$id);

        return $this;
    }
}
