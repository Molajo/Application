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
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $applications;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $model_registry;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $database;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $options;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $request_path;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $request_base_url;

    /**
     * Setup testing
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->model_registry = null;

        $this->database     = new MockDatabase(new MockQuery);
        $this->fieldhandler = new MockFieldHandler();

        $this->applications = $this->mockApplicationInstances();

        return $this;
    }

    /**
     * Recognizes Installation Needed
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationInstallationRequired()
    {
        return $this;
    }

    /**
     * 1. Remove ending slash
     * 2. Matches Installation in the Path
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationInstallation()
    {
        $this->request_path     = 'installation/';
        $this->request_base_url = '';
        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('installation', $this->instance->get('name'));
        $this->assertEquals(0, $this->instance->get('id'));
        $this->assertEquals('installation', $this->instance->get('base_path'));
        $this->assertEquals('', $this->instance->get('path'));

        return $this;
    }

    /**
     * 1. No ending '/'
     * 2. Matches 'admin' in path
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationAdmin()
    {
        $this->request_path     = 'admin';
        $this->request_base_url = '';
        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('admin', $this->instance->get('name'));
        $this->assertEquals(1, $this->instance->get('id'));
        $this->assertEquals('admin', $this->instance->get('base_path'));
        $this->assertEquals('', $this->instance->get('path'));

        return $this;
    }

    /**
     * Sets to default application
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplicationDefault()
    {
        $this->request_path     = '/';
        $this->request_base_url = '/';
        $this->instantiateClass();

        $this->instance->setApplication();

        $this->assertEquals('default', $this->instance->get('name'));
        $this->assertEquals(2, $this->instance->get('id'));
        $this->assertEquals('', $this->instance->get('base_path'));
        $this->assertEquals('', $this->instance->get('path'));

        return $this;
    }

    /**
     * Retrieve Configuration Data
     * 1. Find installation needed
     * 2. retrieve data
     * 3. RuntimeException - query error
     * 4. RuntimeException - No Model Registry
     * 5. Verify appropriate data returns
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function testGetConfigurationInstallation()
    {
        $this->request_path     = 'installation/';
        $this->request_base_url = '';
        $this->instantiateClass();

        $this->instance->setApplication();

        $this->instance->getConfiguration();

        $this->assertEquals(0, $this->instance->getData('id'));
        $this->assertEquals('installation', $this->instance->getData('name'));
        $this->assertEquals('installation', $this->instance->getData('description'));
    }

    /**
     * Retrieve Configuration Data
     * 1. Find installation needed
     * 2. retrieve data
     * 3. RuntimeException - query error
     * 4. RuntimeException - No Model Registry
     * 5. Verify appropriate data returns
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function testGetConfigurationNormal()
    {

    }

    /**
     * Verifies that the Site has permission to utilise this Application
     *
     * @return  $this
     * @since   1.0
     */
    public function testVerifySiteApplication()
    {
// $query->from('#__site_applications'));
    }

    /**
     * Throws exception because the Site does NOT have permission to utilise this Application
     *
     * @expectedException RuntimeException
     */
    public function testVerifySiteApplicationFailure()
    {
        $this->request_path     = '/';
        $this->request_base_url = '/';
        $this->instantiateClass();

        $this->instance->setApplication();

        $this->instance->verifySiteApplication(1);
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
     * Instantiate the class to test
     *
     * @return  array
     * @since   1.0
     */
    public function instantiateClass()
    {
        $this->instance = new MockApplication(
            $this->applications,
            $this->model_registry,
            $this->database,
            $this->fieldhandler,
            $this->request_path,
            $this->request_base_url
        );
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

class MockDatabase implements DatabaseInterface
{
    /**
     * Query
     *
     * @var    object
     * @since  1.0
     */
    protected $query = null;

    /**
     * Constructor
     *
     * @param null|object $query
     *
     * @since  1.0
     */
    public function __construct(
        $query
    ) {
        $this->query = $query;
    }

    public function getQueryObject()
    {
        return $this->query;
    }

    public function getDateFormat()
    {

    }

    public function getDate()
    {

    }

    public function getNullDate()
    {

    }

    public function quote($value)
    {

    }

    public function quoteName($name)
    {

    }

    public function q($value)
    {
        return $this->quote($value);
    }

    public function qn($name)
    {
        return $this->quoteName($name);
    }

    public function escape($text)
    {

    }

    public function loadResult()
    {

    }

    public function loadObjectList($offset = null, $limit = null)
    {

    }

    public function execute($sql = null)
    {

    }

    public function getInsertId()
    {

    }
}

class MockQuery
{
    public function select($field)
    {

    }

    public function from($table)
    {

    }

    public function where($clause)
    {

    }
}

class MockFieldHandler implements FieldhandlerInterface
{
    public function validate(
        $field_name,
        $field_value = null,
        $fieldhandler_type_chain,
        $options = array()
    ) {

    }

    public function filter(
        $field_name,
        $field_value = null,
        $fieldhandler_type_chain,
        $options = array()
    ) {

    }

    public function escape(
        $field_name,
        $field_value = null,
        $fieldhandler_type_chain,
        $options = array()
    ) {

    }
}
