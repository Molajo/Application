<?php
/**
 * Application Configuration
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Application;

use CommonApi\Exception\RuntimeException;
use stdClass;

/**
 * Application Configuration
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Configuration extends Set
{
    /**
     * Installation Application, only
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getConfigurationInstallation()
    {
        if ($this->name === 'installation') {
            $this->data->id          = 0;
            $this->data->name        = $this->name;
            $this->data->description = $this->name;
        }

        return $this;
    }

    /**
     * Run Configuration Query
     *
     * @return  mixed
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function runConfigurationQuery()
    {
        $this->createConfigurationQuery();

        $x = $this->query->loadObjectList($this->query->getSQL());

        if (count($x) === 0) {
            throw new RuntimeException('Application: Error executing getApplication Query');
        }

        return $x[0];
    }

    /**
     * Create Configuration Query
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function createConfigurationQuery()
    {
        $this->query->clearQuery();

        $this->query->select('a.*');
        $this->query->select('b.id', 'catalog_id');
        $this->query->from('#__applications', 'a');
        $this->query->from('#__catalog', 'b');
        $this->query->where('column', 'a.name', '=', 'string', $this->name);
        $this->query->where(
            'column',
            'b.extension_instance_id',
            '=',
            'integer',
            (int)$this->catalog_type_application_id
        );
        $this->query->where('column', 'b.source_id', '=', 'column', 'a.id');
        $this->query->where('column', 'b.application_id', '=', 'column', 'a.id');
        $this->query->where('column', 'b.enabled', '=', 'integer', (int)1);

        return $this;
    }

    /**
     * Set Custom Fields
     *
     * @param   object $data
     * @param   array  $custom_field_types
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setCustomFields($data, array $custom_field_types = array())
    {
        foreach ($custom_field_types as $group) {
            unset($this->data->$group);
            $this->data->$group = $this->processCustomfieldGroup($group, $data);
        }

        return $this;
    }

    /**
     * Process Customfield Group
     *
     * @param   string $group
     * @param   object $data
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function processCustomfieldGroup($group, $data)
    {
        $group_data = $this->getCustomfieldGroupData($group, $data);

        $fields = array();

        foreach ($this->model_registry[$group] as $customfield) {

            foreach ($customfield as $name => $field) {

                $key       = $this->getCustomfieldsDataElement($field, 'name');
                $default   = $this->getCustomfieldsDataElement($field, 'default');
                $value     = $this->setCustomFieldValue($group_data, $key, $default);
                $data_type = $this->getCustomfieldsDataElement($field, 'type');

                if ($data_type === null) {
                    $data_type = 'string';
                }

                $fields[$key] = $this->sanitize($key, $value, $data_type);
            }
        }

        return $this->createCustomFieldGroup($fields);
    }

    /**
     * Get Customfield Group Data
     *
     * @param   object $customfield
     * @param   string $key
     *
     * @return  mixed|stdClass
     */
    protected function getCustomfieldsDataElement($customfield, $key)
    {
        if (isset($customfield[$key])) {
            $value = $customfield[$key];
        } else {
            $value = null;
        }

        return $value;
    }

    /**
     * Set Value for Custom Field
     *
     * @param   object      $group_data
     * @param   string      $key
     * @param   null|string $default
     *
     * @return  mixed|stdClass
     */
    protected function setCustomFieldValue($group_data, $key, $default = null)
    {
        $value = null;

        if (isset($group_data->$key)) {
            $value = $group_data->$key;
        }

        if ($value === null) {
            $value = $default;
        }

        return $value;
    }

    /**
     * Get Customfield Group Data
     *
     * @param   string $group
     * @param   object $data
     *
     * @return  mixed|stdClass
     */
    protected function getCustomfieldGroupData($group, $data)
    {
        if (isset($data->$group)) {
            return json_decode($data->$group);
        }

        return new stdClass();
    }

    /**
     * Create Custom Field Group
     *
     * @param   array $temp
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function createCustomFieldGroup($temp)
    {
        ksort($temp);

        $group_name = new stdClass();

        foreach ($temp as $key => $value) {
            $group_name->$key = $value;
        }

        return $group_name;
    }

    /**
     * Get Configuration Line End and HTML 5 data
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function getConfigurationLineEnd()
    {
        if (isset($this->data->parameters->application_html5)
            && $this->data->parameters->application_html5 === 1
        ) {
            $this->data->parameters->application_line_end = '>' . chr(10);
        } else {
            $this->data->parameters->application_html5    = 0;
            $this->data->parameters->application_line_end = '/>' . chr(10);
        }

        return $this;
    }

    /**
     * Filter Input
     *
     * @param   string $key
     * @param   mixed  $value
     * @param   string $data_type
     *
     * @return  mixed
     * @since   1.0.0
     */
    protected function sanitize($key, $value = null, $data_type = 'string')
    {
        $results = $this->fieldhandler->sanitize($key, $value, $data_type);

        return $results->getFieldValue();
    }
}
