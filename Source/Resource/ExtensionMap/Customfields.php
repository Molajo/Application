<?php
/**
 * Custom Field Logic for Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

use stdClass;

/**
 * Custom Field Logic for Extension Map
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
abstract class Customfields extends Queries
{
    /**
     * Process Customfield Group
     *
     * @param   string $group
     * @param   object $data
     * @param   array  $model_registry
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function processCustomfieldGroup($group, $data, $model_registry)
    {
        $fields = $this->getCustomfields($group, $data, $model_registry);

        $group_fields = new stdClass();

        foreach ($fields as $key => $value) {
            $group_fields->$key = $value;
        }

        return $group_fields;
    }

    /**
     * Get Custom Group Data
     *
     * @param   string $group
     * @param   object $data
     * @param   object $model_registry
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function getCustomfields($group, $data, $model_registry)
    {
        $group_data = $this->getCustomfieldGroupData($group, $data);

        $fields = array();

        foreach ($model_registry[$group] as $customfields) {
            $key          = $customfields['name'];
            $fields[$key] = $this->setCustomfieldValue($key, $group_data, $customfields);
        }
        ksort($fields);

        return $fields;
    }

    /**
     * Get Custom Group Data
     *
     * @param   string $group
     * @param   object $data
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function getCustomfieldGroupData($group, $data)
    {
        if (isset($data->$group)) {
        } else {
            $group_data = new stdClass();
            return $group_data;
        }

        $group_data = json_decode($data->$group);

        $application_id = $this->runtime_data->application->id;

        if (isset($group_data->$application_id)) {
            $group_data = $group_data->$application_id;
        }

        return $group_data;
    }

    /**
     * Set Custom Field Value
     *
     * @param   string $key
     * @param   object $group_data
     * @param   array  $customfields
     *
     * @return  null|mixed
     * @since   1.0.0
     */
    protected function setCustomfieldValue($key, $group_data, $customfields)
    {
        if (isset($group_data->$key)) {
            return $group_data->$key;
        }

        if (isset($customfields['default'])) {
            return $customfields['default'];
        }

        return null;
    }
}
