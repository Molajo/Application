<?php
/**
 * Application Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ApplicationInterface;
use CommonApi\Database\DatabaseInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\Model\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;
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
 * @since      1.0.0
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
     * @var    array
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
     * Query Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $query;

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
     * Application Path
     *
     * @var    string
     * @since  1.0
     */
    protected $path = null;

    /**
     * Constructor
     *
     * @param DatabaseInterface     $database
     * @param QueryInterface        $query
     * @param FieldhandlerInterface $fieldhandler
     * @param string                $request_path
     * @param array                 $applications
     * @param null|object           $model_registry
     *
     * @since  1.0
     */
    public function __construct(
        DatabaseInterface $database,
        QueryInterface $query,
        FieldhandlerInterface $fieldhandler,
        $request_path,
        array $applications = array(),
        $model_registry = null
    ) {
        $this->database       = $database;
        $this->query          = $query;
        $this->fieldhandler   = $fieldhandler;
        $this->request_path   = $request_path;
        $this->applications   = $applications;
        $this->model_registry = $model_registry;
    }

    /**
     * Using Request URI, identify current application and page request
     *
     * @return  $this
     * @since   1.0
     */
    public function setApplication()
    {
        $application_test = $this->setApplicationPath();
        $app              = $this->getApplicationArrayEntry($application_test);

        $this->id   = $app->id;
        $this->name = $app->name;

        if ($app->base_path == '') {
            $this->base_path = '';
            $this->path      = $this->request_path;
        } else {
            $this->base_path = $app->base_path;
            $this->path      = substr($this->request_path, 0, -strlen(trim($this->base_path)));
        }

        if ($this->path === false) {
            $this->path = '';
        } elseif ($this->path === '/') {
            $this->path = '';
        }

        return $this;
    }

    /**
     * Extract Application Path from the Request URL
     *
     * @return  string
     * @since   1.0
     */
    protected function setApplicationPath()
    {
        if (substr($this->request_path, -1) == '/') {
            $this->processRequestPath(0);
        }

        if (substr($this->request_path, 0, 1) == '/') {
            $this->processRequestPath(1);
        }

        if (strpos($this->request_path, '/') == true) {
            $application_test = substr($this->request_path, 0, strpos($this->request_path, '/'));
        } else {
            $application_test = $this->request_path;
        }

        return trim(strtolower($application_test));
    }

    /**
     * Process the Request Path
     *
     * @param   integer $start
     *
     * @return  $this
     * @since   1.0
     */
    protected function processRequestPath($start)
    {
        $this->request_path = substr($this->request_path, $start, strlen($this->request_path) - 1);

        return $this;
    }

    /**
     * Get Application Array Entry
     *
     * @param   $application_test
     *
     * @return  stdClass
     * @since   1.0
     */
    protected function getApplicationArrayEntry($application_test)
    {
        $app = new stdClass();

        if (isset($this->applications[$application_test])) {
            $app = $this->applications[$application_test];

        } else {
            foreach ($this->applications as $key => $application) {
                if ($key === 'default') {
                    $app = $application;
                    break;
                }
            }
        }

        return $app;
    }

    /**
     * Retrieve Application Data
     *
     * @return  $this
     * @since   1.0
     */
    public function getConfiguration()
    {
        $this->data = new stdClass();

        $this->getConfigurationInstallation();

        $data = $this->runConfigurationQuery();

        $this->data->id              = (int)$data->id;
        $this->data->base_path       = $this->base_path;
        $this->data->path            = $this->path;
        $this->data->name            = $data->name;
        $this->data->description     = $data->description;
        $this->data->catalog_id      = (int)$data->catalog_id;
        $this->data->catalog_type_id = (int)$data->catalog_type_id;

        $this->setCustomFields($data, $this->model_registry['customfieldgroups']);

        $this->getConfigurationLineEnd();

        return $this->data;
    }

    /**
     * Installation Application, only
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getConfigurationInstallation()
    {
        if ($this->name == 'installation') {
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

        $x = $this->database->loadObjectList($this->query->getSQL());

        if ($x === false) {
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
     * @since   1.0
     */
    protected function processCustomfieldGroup($group, $data)
    {
        $group_data = $this->getCustomfieldGroupData($group, $data);

        $temp = array();

        foreach ($this->model_registry[$group] as $customfields) {

            $key       = $this->getCustomfieldsDataElement($customfields, 'name');
            $default   = $this->getCustomfieldsDataElement($customfields, 'default');
            $value     = $this->setCustomFieldValue($group_data, $key, $default);
            $data_type = $this->getCustomfieldsDataElement($customfields, 'type');

            if ($data_type === null) {
                $data_type = 'string';
            }

            $temp[$key] = $this->sanitize($key, $value, $data_type);
        }

        return $this->createCustomFieldGroup($temp);
    }

    /**
     * Get Customfield Group Data
     *
     * @param   object $customfields
     * @param   string $key
     *
     * @return  mixed|stdClass
     */
    protected function getCustomfieldsDataElement($customfields, $key)
    {
        if (isset($customfields[$key])) {
            $value = $customfields[$key];
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
            && $this->data->parameters->application_html5 == 1
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
        $this->query->clearQuery();

        $this->query->select('site_id');
        $this->query->from('#__site_applications');
        $this->query->where('column', 'application_id', '=', 'integer', (int)$this->id);
        $this->query->where('column', 'site_id', '=', 'integer', (int)$site_id);

        $returned_site_id = $this->database->loadResult($this->query->getSQL());

        if ((int)$returned_site_id == (int)$site_id) {
            return $this;
        }

        throw new RuntimeException(
            'Application::verifySiteApplication Site: ' . $site_id . ' not authorised for Application: ' . $this->id
        );
    }
}
