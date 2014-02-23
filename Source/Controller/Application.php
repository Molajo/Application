<?php
/**
 * Application Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use Exception;
use CommonApi\Controller\ApplicationInterface;
use CommonApi\Database\DatabaseInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\Model\FieldhandlerInterface;
use stdClass;

/**
 * Application Controller
 *
 * 1. Identifies Current Application
 * 2. Loads Application
 * 3. Defines Site Paths for Application
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Application implements ApplicationInterface
{
    /**
     * Catalog Type Application ID
     *
     * @var    int
     * @since  1.0
     */
    protected $catalog_type_application_id = 2000;

    /**
     * Applications
     *
     * @var    int
     * @since  1.0
     */
    protected $applications = array();

    /**
     * Application Model Registry
     *
     * @var    object
     * @since  1.0
     */
    protected $model_registry = null;

    /**
     * Database Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $database;

    /**
     * Fieldhandler Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Path
     *
     * @var    string
     * @since  1.0
     */
    protected $request_path = null;

    /**
     * Base Request URL
     *
     * @var    string
     * @since  1.0
     */
    protected $request_base_url = null;

    /**
     * Application Data
     *
     * @var    array
     * @since  1.0
     */
    protected $data = null;

    /**
     * Application Name
     *
     * @var    string
     * @since  1.0
     */
    protected $name = null;

    /**
     * Application ID
     *
     * @var    int
     * @since  1.0
     */
    protected $id = null;

    /**
     * Application Base Path
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path = null;

    /**
     * Application Base Path
     *
     * @var    string
     * @since  1.0
     */
    protected $path = null;

    /**
     * Constructor
     *
     * @param array                 $applications
     * @param null|object           $model_registry
     * @param DatabaseInterface     $database
     * @param FieldhandlerInterface $fieldhandler
     * @param string                $request_path
     * @param string                $request_base_url
     *
     * @since  1.0
     */
    public function __construct(
        array $applications = array(),
        $model_registry = null,
        DatabaseInterface $database,
        FieldhandlerInterface $fieldhandler,
        $request_path,
        $request_base_url
    ) {
        $this->applications     = $applications;
        $this->model_registry   = $model_registry;
        $this->database         = $database;
        $this->fieldhandler     = $fieldhandler;
        $this->request_path     = $request_path;
        $this->request_base_url = $request_base_url;
    }

    /**
     * Using Request URI, identify current application and page request
     *
     * @return  $this
     * @since   1.0
     */
    public function setApplication()
    {
        if (substr($this->request_path, - 1) == '/') {
            $this->request_path = substr($this->request_path, 0, strlen($this->request_path) - 1);
        }

        if (strpos($this->request_path, '/') == true) {
            $application_test = substr($this->request_path, 0, strpos($this->request_path, '/'));
        } else {
            $application_test = $this->request_path;
        }

        $application_test = trim(strtolower($application_test));

        if (isset($this->applications[$application_test])) {
            $app = $this->applications[$application_test];
        } else {
            $app = $this->applications['default'];
        }

        $this->name = $app->name;
        $this->id   = $app->id;

        if ($app->base_path == '') {
            $this->base_path = '';
            $this->path      = $this->request_path;
        } else {
            $this->base_path = $app->name;
            $this->path      = substr($this->request_path, strlen(trim($this->base_path)), 999);
        }

        if ($this->path === false) {
            $this->path = '';
        } elseif ($this->path === '/') {
            $this->path = '';
        }
        return $this;
    }

    /**
     * Retrieve Application Data
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getConfiguration()
    {
        $this->data = new stdClass();

        if ($this->name == 'installation') {
            $this->data->id          = 0;
            $this->data->name        = $this->name;
            $this->data->description = $this->name;

            return $this;
        }

        $query = $this->database->getQueryObject();

        $query->select('a.*');
        $query->select('b.id' . ' as catalog_id');
        $query->from($this->database->qn('#__applications') . ' ' . $this->database->qn('a'));
        $query->from($this->database->qn('#__catalog') . ' ' . $this->database->qn('b'));
        $query->where(
            $this->database->qn('a.name')
            . ' = ' . $this->database->q($this->name)
        );
        $query->where(
            $this->database->qn('b.extension_instance_id')
            . ' = ' . $this->database->q($this->catalog_type_application_id)
        );
        $query->where(
            $this->database->qn('b.source_id')
            . ' = ' . $this->database->qn('a.id')
        );
        $query->where(
            $this->database->qn('b.application_id')
            . ' = ' . $this->database->qn('a.id')
        );

        $query->where(
            $this->database->qn('b.enabled')
            . ' = ' . $this->database->q(1)
        );

        $x = $this->database->loadObjectList();

        if ($x === false) {
            throw new RuntimeException ('Application: Error executing getApplication Query');
        } else {
            $data = $x[0];
        }

        if ($this->model_registry === null) {
            throw new RuntimeException ('Application: Model Registry for Application Configuration missing');
        }

        $this->data->id              = (int)$data->id;
        $this->data->base_path       = $this->base_path;
        $this->data->path            = $this->path;
        $this->data->name            = $data->name;
        $this->data->description     = $data->description;
        $this->data->catalog_id      = (int)$data->catalog_id;
        $this->data->catalog_type_id = (int)$data->catalog_type_id;

        $custom_field_types = $this->model_registry['customfieldgroups'];

        if (is_array($custom_field_types)) {
        } else {
            $custom_field_types = array();
        }

        if (count($custom_field_types) > 0) {
            if (is_array($custom_field_types) && count($custom_field_types) > 0) {
                foreach ($custom_field_types as $group) {
                    unset($this->data->$group);
                    $this->data->$group = $this->processCustomfieldGroup($group, $data);
                }
            }
        }

        if (isset($this->data->parameters->application_html5)
            && $this->data->parameters->application_html5 == 1
        ) {
            $this->data->parameters->application_line_end = '>' . chr(10);
        } else {
            $this->data->parameters->application_html5    = 0;
            $this->data->parameters->application_line_end = '/>' . chr(10);
        }

        return $this->data;
    }

    /**
     * Check if the Site has permission to utilise this Application
     *
     * @param   int $site_id
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function verifySiteApplication($site_id)
    {
        $query = $this->database->getQueryObject();

        $query->select($this->database->qn('site_id'));
        $query->from($this->database->qn('#__site_applications'));
        $query->where(
            $this->database->qn('application_id')
            . ' = ' . $this->database->q($this->id)
        );
        $query->where(
            $this->database->qn('site_id')
            . ' = ' . (int) $site_id
        );

        $valid = $this->database->loadResult();

        if ($valid === (int) $site_id) {
            return $this;
        }

        throw new RuntimeException ('Application: Error executing getApplication Query');
    }

    /**
     * Process Customfield Group
     *
     * @param   string $group
     * @param   object $data
     *
     * @return  stdClass
     * @since   1.0
     */
    protected function processCustomfieldGroup($group, $data)
    {
        if (isset($data->$group)) {
            $group_data = json_decode($data->$group);
        } else {
            $group_data = new stdClass();
        }

        $temp = array();

        foreach ($this->model_registry[$group] as $customfields) {

            $key = $customfields['name'];

            $value = null;

            if (isset($group_data->$key)) {
                $value = $group_data->$key;
            }

            if ($value === null || $value == '' || $value == ' ') {

                if (isset($customfields['default'])) {
                    $default = $customfields['default'];
                } else {
                    $default = false;
                }

                $value = $default;
            }

            if (isset($customfields['type'])) {
                $data_type = $customfields['type'];
            } else {
                $data_type = 'char';
            }

            $temp[$key] = $this->filter($key, $value, $data_type);
        }

        ksort($temp);

        $group_name = new stdClass();
        foreach ($temp as $key => $value) {
            $group_name->$key = $value;
        }

        return $group_name;
    }

    /**
     * Filter Input
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  string $data_type
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function filter($key, $value = null, $data_type)
    {
        if ($data_type == 'text') {
            $filter = 'Html';

        } elseif ($data_type == 'char') {
            $filter = 'String';

        } elseif ($data_type == 'image') {
            $filter = 'Url';

        } elseif (substr($data_type, strlen($data_type) - 3, 3) == '_id'
            || $key == 'id'
            || $data_type == 'integer'
            || $data_type == 'catalog_id'
            || $data_type == 'status'
        ) {
            $filter = 'Int';
        } elseif ($data_type == 'char') {
            $filter = 'String';
        } else {
            $filter = $data_type;
        }

        try {
            $value = $this->fieldhandler->filter($key, $value, $filter);

        } catch (Exception $e) {
            throw new RuntimeException
            ('Request: Filter class Failed for Key: ' . $key . ' Filter: ' . $filter . ' ' . $e->getMessage());
        }

        return $value;
    }
}
