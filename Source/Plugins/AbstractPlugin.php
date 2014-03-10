<?php
/**
 * Abstract Plugin
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugins;

use CommonApi\Exception\RuntimeException;
use Exception;
use stdClass;

/**
 * Abstract Plugin - Overrides Abstract Plugin in Event Package
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
abstract class AbstractPlugin
{
    /**
     * Plugin Name
     *
     * @var    string
     * @since  1.0
     */
    protected $plugin_name = null;

    /**
     * Event Name
     *
     * @var    string
     * @since  1.0
     */
    protected $event_name = null;

    /**
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Fieldhandler
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler = null;

    /**
     * Date Controller
     *
     * @var    object  CommonApi\Controller\DateInterface
     * @since  1.0
     */
    protected $date_controller = null;

    /**
     * Url Controller
     *
     * @var    object  CommonApi\Controller\UrlInterface
     * @since  1.0
     */
    protected $url_controller = null;

    /**
     * Language Instance
     *
     * @var    object CommonApi\Language\LanguageInterface
     * @since  1.0
     */
    protected $language_controller;

    /**
     * Authorisation Controller
     *
     * @var    object  CommonApi\Authorisation\AuthorisationInterface
     * @since  1.0
     */
    protected $authorisation_controller;

    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0
     */
    protected $runtime_data = null;

    /**
     * Plugin Data
     *
     * @var    object
     * @since  1.0
     */
    protected $plugin_data = null;

    /**
     * Parameters
     *
     * @var    object
     * @since  1.0
     */
    protected $parameters = null;

    /**
     * Query
     *
     * @var    object
     * @since  1.0
     */
    protected $query = null;

    /**
     * Model Registry
     *
     * @var    object
     * @since  1.0
     */
    protected $model_registry = null;

    /**
     * Query Results
     *
     * @var    array
     * @since  1.0
     */
    protected $query_results = array();

    /**
     * Query Results
     *
     * @var    object
     * @since  1.0
     */
    protected $row = null;

    /**
     * View Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_view = null;

    /**
     * Page Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_page = null;

    /**
     * Form Sections
     *
     * @var    array
     * @since  1.0
     */
    protected $form_sections = array();

    /**
     * Sections
     *
     * @var    array
     * @since  1.0
     */
    protected $form_section_fieldsets = array();

    /**
     * Fields
     *
     * @var    array
     * @since  1.0
     */
    protected $form_section_fieldset_fields = array();

    /**
     * Constructor
     *
     * @param  string  $plugin_name
     * @param  string  $event_name
     * @param  array   $data
     *
     * @since  1.0
     */
    public function __construct(
        $plugin_name = '',
        $event_name = '',
        array $data = array()
    ) {
        $this->plugin_name = $plugin_name;
        $this->event_name  = $event_name;

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Get the current value (or default) of the specified property
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }

        $results = array();

        $results['runtime_data']   = $this->runtime_data;
        $results['plugin_data']    = $this->plugin_data;
        $results['parameters']     = $this->parameters;
        $results['query']          = $this->query;
        $results['model_registry'] = $this->model_registry;
        $results['query_results']  = $this->query_results;
        $results['row']            = $this->row;
        $results['rendered_page']  = $this->rendered_page;
        $results['rendered_view']  = $this->rendered_view;

        return $results;
    }

    /**
     * Get Field Definition for specific Field Name
     *
     * @param   string     $name
     * @param   null|mixed $default
     *
     * @return  mixed
     * @since   1.0
     */
    public function getField($name, $default = null)
    {
        if (isset($this->model_registry->field->$name)) {
        } else {
            $this->model_registry->field->$name = $default;
        }

        return $this->row->$name;
    }

    /**
     * Retrieve Fields for a specified Data Type
     *
     * @param   string $type
     *
     * @return  array
     * @since   1.0
     */
    public function getFieldsByType($type)
    {
        $results = array();

        if (isset($this->model_registry['fields'])) {
        } else {
            return array();
        }

        foreach ($this->model_registry['fields'] as $field) {
            if ($field['type'] == $type) {
                $results[] = $field;
            }
        }

        return $results;
    }

    /**
     * getFieldValue retrieves the actual field value from the 'normal' or special field
     *
     * @param   object $field
     *
     * @return  null|mixed
     * @since   1.0
     */
    public function getFieldValue($field)
    {
        if (isset($field['as_name'])) {
            if ($field['as_name'] == '') {
                $name = $field['name'];
            } else {
                $name = $field['as_name'];
            }
        } else {
            $name = $field['name'];
        }

        if (isset($this->row->$name)) {
            return $this->row->$name;

        } elseif (isset($field['default'])) {
            return $field['default'];
        }

        return null;
    }

    /**
     * setField adds a field to the 'normal' or special field group
     *
     * @param   $field
     * @param   $new_field_name
     * @param   $value
     *
     * @return  $this
     * @since   1.0
     */
    public function setField($field, $new_field_name, $value)
    {
        if (is_object($this->row)) {
        } else {
            $this->row = new stdClass();
        }

        $this->row->$new_field_name = $value;

        if (is_array($this->model_registry['fields'])) {
        } else {
            $this->model_registry['fields'] = array();
        }

        if (isset($this->model_registry['fields'])) {
            foreach ($this->model_registry['fields'] as $field) {
                if ($field['type'] == $new_field_name) {
                    return $this;
                }
            }
        }

        $temp                             = $field;
        $temp['name']                     = $new_field_name;
        $temp['calculated']               = 1;
        $this->model_registry['fields'][] = $temp;

        return $this;
    }

    /**
     * saveForeignKeyValue
     *
     * @param   $new_field_name
     * @param   $value
     *
     * @return void
     * @since   1.0
     */
    public function saveForeignKeyValue($new_field_name, $value)
    {
        if (is_object($this->row)) {
        } else {
            $this->row = new stdClass();
        }

        if (isset($this->row->$new_field_name)) {
            return;
        }

        $this->row->$new_field_name = $value;

        return;
    }

    /**
     * Filter Input
     *
     * @param   string $key
     * @param   mixed  $value
     * @param   string $filter
     * @param   array  $filter_options
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function filter($key, $value = null, $filter, $filter_options = array())
    {
        if (isset($filter_options['data_type'])) {
            $filter = $this->setFilter($filter_options['data_type']);
        }

        try {
            $value = $this->fieldhandler->filter($key, $value, $filter, $filter_options);

        } catch (Exception $e) {
            throw new RuntimeException
            ('Request: Filter class Failed for Key: ' . $key . ' Filter: ' . $filter . ' ' . $e->getMessage());
        }

        return $value;
    }

    /**
     * Set Filter by Data Type
     *
     * @param   $data_type
     *
     * @return  string
     * @since   1.0
     */
    protected function setFilter($data_type)
    {
        if ($data_type == 'text') {
            $filter = 'Html';

        } elseif ($data_type == 'char') {
            $filter = 'String';

        } elseif ($data_type == 'image') {
            $filter = 'Url';

        } elseif (substr($data_type, strlen($data_type) - 3, 3) == '_id'
            || $data_type == 'integer'
            || $data_type == 'integer'
            || $data_type == 'catalog_id'
            || $data_type == 'status'
        ) {
            $filter = 'Int';

        } elseif ($data_type == 'char') {
            $filter = 'String';

        } elseif ($data_type == 'tel') {
            $filter = 'String';

        } elseif ($data_type == 'datetime') {
            $filter = 'Date';

        } else {
            $filter = $data_type;
        }

        return $filter;
    }

    /**
     * Get Filter
     *
     * @return  int
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getFilter($list)
    {
        $catalog_type_id         = 0;
        $options                 = array();
        $options['runtime_data'] = $this->runtime_data;
        $options['plugin_data']  = $this->plugin_data;
        $model                   = 'Molajo//Model//Datalist//' . $list . '.xml';

        $controller = $this->resource->get('query:///' . $model, $options);

        $controller->setModelRegistry('process_events', 0);
        $controller->setModelRegistry('get_customfields', 0);
        $controller->setModelRegistry('query_object', 'list');
        $controller->setModelRegistry('use_pagination', 0);

        $catalog_type_id = $controller->getModelRegistry('criteria_catalog_type_id');

        if ((string)$catalog_type_id == '*') {
            if (isset($this->plugin_data->resource->data->parameters->criteria_catalog_type_id)) {
                $catalog_type_id = $this->plugin_data->resource->data->parameters->criteria_catalog_type_id;
            }
        }

        if ((int)$catalog_type_id === 0) {
        } else {
            $controller->model->query->where(
                $controller->model->database->qn($controller->getModelRegistry('primary_prefix', 'a'))
                . '.' . $controller->model->database->qn('catalog_type_id')
                . ' = '
                . (int)$catalog_type_id
            );
        }

        try {
            $results = $controller->getData();

            $multiple   = (int)$controller->getModelRegistry('multiple');
            $size       = (int)$controller->getModelRegistry('size');
            $structured = array();

            if (is_array($results) && count($results) > 0) {

                foreach ($results as $item) {

                    $first          = 1;
                    $row            = new stdClass();
                    $row->list_name = $list;

                    foreach ($item as $property => $value) {
                        if ($first === 1) {
                            $row->id = $value;
                        } else {
                            $row->value = $value;
                        }
                        $first = 0;
                    }

                    if ((int)$multiple === 0) {
                        $row->multiple = '';
                        $row->size     = 0;
                    } else {
                        $row->multiple = ' multiple';
                        if ((int)$size === 0) {
                            $size = 5;
                        }
                    }

                    if ((int)$size === 0) {
                        $row->size = '';
                    } else {
                        $row->size = ' size="' . (int)$size . '"';
                    }

                    $row->selected     = '';
                    $row->no_selection = 1;
                    $structured[]      = $row;
                }
            }

        } catch (Exception $e) {
            throw new RuntimeException ($e->getMessage());
        }

        return $structured;
    }

    /**
     * Stores Form Sections
     *
     * @param   string $section_array
     *
     * @return  $this
     * @since   1.0
     */
    public function setFormSections($section_array)
    {
        $temp          = explode('{{', $section_array);
        $form_sections = array();
        foreach ($temp as $section) {
            $x = substr($section, 0, strlen($section) - 2);
            if ($x === false) {
            } else {
                $y                    = explode(',', $x);
                $form_sections[$y[0]] = $y[1];
            }
        }

        $section_array = array();
        $active        = ' active';
        foreach ($form_sections as $key => $value) {
            $row                 = new stdClass();
            $row->template_label = $key;
            $row->template_view  = $value;
            $row->active         = $active;
            $section_array[]     = $row;
            $active              = '';
        }

        $this->form_sections = $section_array;

        return $this;
    }

    /**
     * Stores Form Section Fieldsets
     *
     * @return  $this
     * @since   1.0
     */
    public function setFormSectionFieldsets($parameters)
    {
        $this->form_section_fieldsets = array();

        foreach ($this->form_sections as $item) {

            $field                  = $item->template_view;
            $y                      = strtolower($field);
            $form_section_fieldsets = array();

            if (isset($parameters->$y)) {

                $x                      = $parameters->$y;
                $temp                   = explode('{{', $x);

                foreach ($temp as $section) {

                    $x = substr($section, 0, strlen($section) - 2);

                    if (trim($x) == '') {
                    } else {
                        $y                             = explode(',', $x);
                        $item->template_view           = ucfirst(strtolower($item->template_view));
                        $row                           = new stdClass();
                        $row->template_label           = $item->template_label;
                        $row->template_view            = $item->template_view;
                        $row->field_masks              = $y[1];
                        $form_section_fieldsets[$y[1]] = $row;
                    }
                }
            }

            $this->form_section_fieldsets[$item->template_view] = $form_section_fieldsets;
        }

        return $this;
    }

    /**
     * Extract Form Fields
     *
     * @return  $this
     * @since   1.0
     */
    public function setFormFieldsetFields($parameters, $model_registry, $map_to_actual = true)
    {
        $this->form_section_fieldset_fields = array();

        $all_fields = $this->getAllFields($model_registry);

        $this->form_section_fieldset_fields = array();

        foreach ($this->form_section_fieldsets as $ignore => $items) {

            $i = 0;
            foreach ($items as $key => $item) {

                $fields = $this->getFieldsetFields($item->field_masks, $parameters, $map_to_actual);

                if (is_array($fields) && count($fields) > 0) {

                    foreach ($fields as $field) {

                        $row       = new stdClass();
                        $row->id   = $i ++;
                        $row->name = $field;

                        foreach ($item as $property => $property_value) {
                            $row->$property = $property_value;
                        }

                        foreach ($all_fields as $all_field) {

                            if ($field == $all_field->name) {
                                foreach ($all_field as $property => $property_value) {
                                    $row->$property = $property_value;
                                }
                                break;
                            }
                        }

                        $this->form_section_fieldset_fields[$row->name] = $row;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Extract Fieldset Fields
     *
     * @return  object
     * @since   1.0
     */
    public function getFieldsetFields($field_mask, $parameters, $map_to_actual = true)
    {
        $masks = explode(',', $field_mask);

        if (is_array($masks) && count($masks) > 0) {
        } else {
            return array();
        }

        $save_field = array();

        foreach ($masks as $mask) {

            $x = substr($mask, strlen($mask) - 1, 1);
            if ($x == '*') {
                $mask = substr($mask, 0, strlen($mask) - 1);
            }

            foreach ($parameters as $key => $value) {
                if (substr($key, 0, strlen($mask)) == $mask) {
                    if (isset($parameters->$key)) {
                        if ($map_to_actual === true) {
                            $selected_field = $parameters->$key;
                        } else {
                            $selected_field = $key;
                        }
                        if (trim($selected_field) == '') {
                        } elseif (substr($selected_field, 0, 2) == '{{') {
                        } else {
                            $save_field[] = $selected_field;
                        }
                    }
                }
            }
        }

        return $save_field;
    }

    /**
     * Extract Form Fields
     *
     * @return  $this
     * @since   1.0
     */
    public function getAllFields($model_registry)
    {
        $all_fields = array();

        $fields = $model_registry['fields'];

        if (is_array($fields) && count($fields) > 0) {
            foreach ($fields as $field) {
                $row = new stdClass();

                foreach ($field as $key => $value) {
                    $row->$key = $value;
                }

                $row->fieldtype = 'field';
                $name           = $row->name;
                $all_fields[]   = $row;
            }
        }

        $customfieldgroups = $model_registry['customfieldgroups'];
        if (is_array($customfieldgroups) && count($customfieldgroups) > 0) {
            foreach ($customfieldgroups as $customfieldgroup) {

                $fields = $model_registry[$customfieldgroup];

                if (is_array($fields) && count($fields) > 0) {
                    foreach ($fields as $field) {
                        $row = new stdClass();

                        foreach ($field as $key => $value) {
                            $row->$key = $value;
                        }

                        $row->fieldtype = $customfieldgroup;
                        $name           = $row->name;
                        $all_fields[]   = $row;
                    }
                }
            }
        }

        sort($all_fields);

        return $all_fields;
    }
}
