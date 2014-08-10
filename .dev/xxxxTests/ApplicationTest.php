<?php
/**
 * Application Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Controller\ApplicationInterface;
use CommonApi\Database\DatabaseInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\Model\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;
use Molajo\Controller\Application;
use stdClass;

/**
 * Application Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance
     *
     * @var    array
     * @since  1.0
     */
    protected $instance;

    /**
     * Database
     *
     * @var    object
     * @since  1.0
     */
    protected $database;

    /**
     * Query
     *
     * @var    object
     * @since  1.0
     */
    protected $query;

    /**
     * Fieldhandler
     *
     * @var    object
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Request Path
     *
     * @var    string
     * @since  1.0
     */
    protected $request_path;

    /**
     * Applications
     *
     * @var    array
     * @since  1.0
     */
    protected $applications;

    /**
     * Model Registry
     *
     * @var    array
     * @since  1.0
     */
    protected $model_registry;

    /**
     * Setup testing
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->database       = new MockDatabase();
        $this->query          = new MockQuery(new stdClass());
        $this->fieldhandler   = new MockFieldHandler();
        $this->request_path   = 'example.com/admin/';
        $this->applications   = $this->mockApplicationInstances();
        $this->model_registry = null;

        return $this;
    }

    /**
     * Instantiate the class to test
     *
     * @return  array
     * @since   1.0
     */
    public function instantiateClass()
    {
        $this->instance = new MockApplication(
            $this->database,
            $this->query,
            $this->fieldhandler,
            $this->request_path,
            $this->applications,
            $this->model_registry
        );
    }

    /**
     * @covers  Molajo\Controller\Application::__construct
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::setApplicationPath
     * @covers  Molajo\Controller\Application::setApplicationBasePath
     * @covers  Molajo\Controller\Application::processRequestPath
     * @covers  Molajo\Controller\Application::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::getConfigurationInstallation
     * @covers  Molajo\Controller\Application::runConfigurationQuery
     * @covers  Molajo\Controller\Application::createConfigurationQuery
     * @covers  Molajo\Controller\Application::setCustomFields
     * @covers  Molajo\Controller\Application::processCustomfieldGroup
     * @covers  Molajo\Controller\Application::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application::setCustomFieldValue
     * @covers  Molajo\Controller\Application::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application::createCustomFieldGroup
     * @covers  Molajo\Controller\Application::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application::sanitize
     * @covers  Molajo\Controller\Application::verifySiteApplication
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationTrailSlashSite()
    {
        $this->request_path = 'example.com/';

        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('', $this->instance->get('base_path'));
        $this->assertEquals('default', $this->instance->get('name'));
        $this->assertEquals(2, $this->instance->get('id'));
        $this->assertEquals('example.com', $this->instance->get('path'));
        $this->assertEquals($this->applications, $this->instance->get('applications'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::__construct
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::setApplicationPath
     * @covers  Molajo\Controller\Application::setApplicationBasePath
     * @covers  Molajo\Controller\Application::processRequestPath
     * @covers  Molajo\Controller\Application::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::getConfigurationInstallation
     * @covers  Molajo\Controller\Application::runConfigurationQuery
     * @covers  Molajo\Controller\Application::createConfigurationQuery
     * @covers  Molajo\Controller\Application::setCustomFields
     * @covers  Molajo\Controller\Application::processCustomfieldGroup
     * @covers  Molajo\Controller\Application::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application::setCustomFieldValue
     * @covers  Molajo\Controller\Application::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application::createCustomFieldGroup
     * @covers  Molajo\Controller\Application::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application::sanitize
     * @covers  Molajo\Controller\Application::verifySiteApplication
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationNoTrailSlashSite()
    {
        $this->request_path = 'example.com';

        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('', $this->instance->get('base_path'));
        $this->assertEquals('default', $this->instance->get('name'));
        $this->assertEquals(2, $this->instance->get('id'));
        $this->assertEquals('example.com', $this->instance->get('path'));
        $this->assertEquals($this->applications, $this->instance->get('applications'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::__construct
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::setApplicationPath
     * @covers  Molajo\Controller\Application::setApplicationBasePath
     * @covers  Molajo\Controller\Application::processRequestPath
     * @covers  Molajo\Controller\Application::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::getConfigurationInstallation
     * @covers  Molajo\Controller\Application::runConfigurationQuery
     * @covers  Molajo\Controller\Application::createConfigurationQuery
     * @covers  Molajo\Controller\Application::setCustomFields
     * @covers  Molajo\Controller\Application::processCustomfieldGroup
     * @covers  Molajo\Controller\Application::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application::setCustomFieldValue
     * @covers  Molajo\Controller\Application::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application::createCustomFieldGroup
     * @covers  Molajo\Controller\Application::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application::sanitize
     * @covers  Molajo\Controller\Application::verifySiteApplication
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationTrailSlashAdmin()
    {
        $this->request_path = 'example.com/admin/';

        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('admin', $this->instance->get('base_path'));
        $this->assertEquals('admin', $this->instance->get('name'));
        $this->assertEquals(1, $this->instance->get('id'));
        $this->assertEquals('example.com/', $this->instance->get('path'));
        $this->assertEquals($this->applications, $this->instance->get('applications'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::__construct
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::setApplicationPath
     * @covers  Molajo\Controller\Application::setApplicationBasePath
     * @covers  Molajo\Controller\Application::processRequestPath
     * @covers  Molajo\Controller\Application::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::getConfigurationInstallation
     * @covers  Molajo\Controller\Application::runConfigurationQuery
     * @covers  Molajo\Controller\Application::createConfigurationQuery
     * @covers  Molajo\Controller\Application::setCustomFields
     * @covers  Molajo\Controller\Application::processCustomfieldGroup
     * @covers  Molajo\Controller\Application::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application::setCustomFieldValue
     * @covers  Molajo\Controller\Application::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application::createCustomFieldGroup
     * @covers  Molajo\Controller\Application::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application::sanitize
     * @covers  Molajo\Controller\Application::verifySiteApplication
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationNoTrailSlashAdmin()
    {
        $this->request_path = 'example.com/admin';

        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('admin', $this->instance->get('base_path'));
        $this->assertEquals('admin', $this->instance->get('name'));
        $this->assertEquals(1, $this->instance->get('id'));
        $this->assertEquals('example.com/', $this->instance->get('path'));
        $this->assertEquals($this->applications, $this->instance->get('applications'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::__construct
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::setApplicationPath
     * @covers  Molajo\Controller\Application::setApplicationBasePath
     * @covers  Molajo\Controller\Application::processRequestPath
     * @covers  Molajo\Controller\Application::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::getConfigurationInstallation
     * @covers  Molajo\Controller\Application::runConfigurationQuery
     * @covers  Molajo\Controller\Application::createConfigurationQuery
     * @covers  Molajo\Controller\Application::setCustomFields
     * @covers  Molajo\Controller\Application::processCustomfieldGroup
     * @covers  Molajo\Controller\Application::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application::setCustomFieldValue
     * @covers  Molajo\Controller\Application::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application::createCustomFieldGroup
     * @covers  Molajo\Controller\Application::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application::sanitize
     * @covers  Molajo\Controller\Application::verifySiteApplication
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetConfiguration()
    {
        $this->request_path = 'example.com/admin';

        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('admin', $this->instance->get('base_path'));
        $this->assertEquals('admin', $this->instance->get('name'));
        $this->assertEquals(1, $this->instance->get('id'));
        $this->assertEquals('example.com/', $this->instance->get('path'));
        $this->assertEquals($this->applications, $this->instance->get('applications'));

        return $this;
    }

    /**
     * Tear down
     *
     * @return  $this
     * @since   1.0
     */
    protected function tearDown()
    {

    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    protected function mockApplicationInstances()
    {
        $applications = array();

        $row                   = new stdClass();
        $row->name             = 'admin';
        $row->id               = 1;
        $row->base_path        = 'admin';
        $applications['admin'] = $row;

        $row                     = new stdClass();
        $row->name               = 'default';
        $row->id                 = 2;
        $row->base_path          = '';
        $applications['default'] = $row;


        $row                          = new stdClass();
        $row->name                    = 'installation';
        $row->id                      = 0;
        $row->base_path               = 'installation';
        $applications['installation'] = $row;

        return $applications;
    }
}

class MockApplication extends Application implements ApplicationInterface
{
    public function get($key)
    {
        return $this->$key;
    }

    public function getData($key)
    {
        return $this->data->$key;
    }
}

use Molajo\Database\Adapter\Joomla;

class MockDatabase extends Joomla implements DatabaseInterface
{
    public function loadResult($sql)
    {

    }

    public function loadObjectList($offset = null, $limit = null)
    {
        $data                  = new stdClass();
        $data->id              = 1;
        $data->base_path       = 'admin';
        $data->path            = 'admin';
        $data->name            = 'Administrator';
        $data->description     = 'Administrator';
        $data->catalog_id      = 1;
        $data->catalog_type_id = 2;

        $data->custom_fields = array();


        $group = array();

        $field            = array();
        $field['name']    = 'food';
        $field['default'] = 'ice cream';
        $field['type']    = 'string';

        $group[] = $field;

        $field            = array();
        $field['name']    = 'animal';
        $field['default'] = 'dog';
        $field['type']    = 'string';

        $group[] = $field;

        $model_registry                  = array();
        $model_registry['custom_fields'] = $group;

    }
}

use Molajo\Query\Driver;

class MockQuery extends Driver implements QueryInterface
{
    protected $adapter;

    /**
     * Constructor
     *
     * @param  QueryInterface $adapter
     *
     * @since  1.0
     */
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    public function clearQuery()
    {

    }

    /**
     * Used for select, insert, and update to specify column name, alias (optional)
     *  For Insert and Update, only, value and data_type
     *
     * @param   string      $column_name
     * @param   null|string $alias
     * @param   null|string $value
     * @param   null|string $data_type
     *
     * @return  $this
     * @since   1.0
     * @throws \CommonApi\Exception\RuntimeException
     */
    public function select($column_name, $alias = null, $value = null, $data_type = null)
    {

    }

    /**
     * Set From table name and optional value for alias
     *
     * @param   string      $table_name
     * @param   null|string $alias
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function from($table_name, $alias = null)
    {

    }

    /**
     * Set Where Conditions for Query
     *
     * @param   string      $left_filter
     * @param   string      $left
     * @param   string      $condition
     * @param   string      $right_filter
     * @param   string      $right
     * @param   string      $connector
     * @param   null|string $group
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function where(
        $left_filter = 'column',
        $left,
        $condition,
        $right_filter = 'column',
        $right,
        $connector = 'and',
        $group = ''
    ) {

    }

    /**
     * Get SQL (optionally setting the SQL)
     *
     * @param   null|string $sql
     *
     * @return  string
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getSQL($sql = null)
    {

    }
}

class MockFieldHandler implements FieldhandlerInterface
{
    public function validate($field_name, $field_value = null, $constraint, array $options = array())
    {

    }

    public function sanitize($field_name, $field_value = null, $constraint, array $options = array())
    {

    }

    public function format($field_name, $field_value = null, $constraint, array $options = array())
    {

    }
}
