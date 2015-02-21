<?php
/**
 * Application Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ApplicationInterface;
use Molajo\Query\QueryMock;
use Molajo\Model\FieldhandlerMock;
use stdClass;

/**
 * Css Folder and File Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Focus of test
     *
     * @var    object
     * @since  1.0.0
     */
    protected $test_instance;

    /**
     * Get Applications
     *
     * @return  array
     * @since   1.0.0
     */
    protected function getApplications()
    {
        $applications = array();

        $row            = new stdClass();
        $row->name      = 'site';
        $row->id        = 1;
        $row->base_path = '';
        $row->default   = 1;

        $applications['site'] = $row;

        $row            = new stdClass();
        $row->name      = 'installation';
        $row->id        = 0;
        $row->base_path = 'installation';
        $row->default   = 0;

        $applications['installation'] = $row;

        $row            = new stdClass();
        $row->name      = 'admin';
        $row->id        = 2;
        $row->base_path = 'admin';
        $row->default   = 0;

        $applications['admin'] = $row;

        return $applications;
    }

    /**
     * Get Model Registry
     *
     * @return  array
     * @since   1.0.0
     */
    protected function getModelRegistry()
    {
        $model_registry = array();

        $model_registry['check_view_level_access']  = 1;
        $model_registry['criteria_catalog_type_id'] = 2000;
        $model_registry['customfieldgroups']        = array('metadata', 'parameters');

        // FIELDS
        $model_registry['fields'] = array();

        $row                            = array();
        $row['name']                    = 'id';
        $row['default']                 = '';
        $row['null']                    = '1';
        $row['type']                    = 'integer';
        $model_registry['fields']['id'] = $row;

        $row                              = array();
        $row['name']                      = 'name';
        $row['default']                   = '';
        $row['null']                      = '0';
        $row['type']                      = 'string';
        $model_registry['fields']['name'] = $row;

        // METADATA
        $model_registry['metadata'] = array();

        $row                                  = array();
        $row['name']                          = 'author';
        $row['default']                       = '';
        $row['null']                          = '0';
        $row['type']                          = 'string';
        $model_registry['metadata']['author'] = $row;

        $row                                 = array();
        $row['name']                         = 'title';
        $row['default']                      = '';
        $row['null']                         = '0';
        $row['type']                         = 'string';
        $model_registry['metadata']['title'] = $row;

        $row                                       = array();
        $row['name']                               = 'description';
        $row['default']                            = '';
        $row['null']                               = '0';
        $row['type']                               = 'string';
        $model_registry['metadata']['description'] = $row;

        // PARAMETERS
        $model_registry['parameters'] = array();

        $row                                                          = array();
        $row['name']                                                  = 'application_default_theme_id';
        $row['default']                                               = '';
        $row['null']                                                  = '0';
        $row['type']                                                  = 'integer';
        $model_registry['parameters']['application_default_theme_id'] = $row;

        $row                                                         = array();
        $row['name']                                                 = 'application_home_catalog_id';
        $row['default']                                              = '';
        $row['null']                                                 = '0';
        $row['type']                                                 = 'string';
        $model_registry['parameters']['application_home_catalog_id'] = $row;

        $model_registry['table_name'] = '#__applications';

        return $model_registry;
    }

    /**
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::verifySiteApplication
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationInstallation
     * @covers  Molajo\Controller\Application\Configuration::runConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::createConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::setCustomFields
     * @covers  Molajo\Controller\Application\Configuration::processCustomfieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application\Configuration::setCustomFieldValue
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application\Configuration::createCustomFieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application\Configuration::sanitize
     * @covers  Molajo\Controller\Application\Set::setApplicationPath
     * @covers  Molajo\Controller\Application\Set::processRequestPath
     * @covers  Molajo\Controller\Application\Set::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application\Set::setApplicationBasePath
     * @covers  Molajo\Controller\Application\Base::__construct
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testSetApplicationDefault()
    {
        // SETUP
        $query          = new QueryMock();
        $fieldhandler   = new FieldhandlerMock();
        $base_path      = 'articles';
        $applications   = $this->getApplications();
        $model_registry = $this->getModelRegistry();

        $this->test_instance = new MockApplication(
            $query,
            $fieldhandler,
            $base_path,
            $applications,
            $model_registry
        );
        // End SETUP

        $this->test_instance->setApplication();

        $this->assertEquals(1, $this->test_instance->get('id'));
        $this->assertEquals('site', $this->test_instance->get('name'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::verifySiteApplication
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationInstallation
     * @covers  Molajo\Controller\Application\Configuration::runConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::createConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::setCustomFields
     * @covers  Molajo\Controller\Application\Configuration::processCustomfieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application\Configuration::setCustomFieldValue
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application\Configuration::createCustomFieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application\Configuration::sanitize
     * @covers  Molajo\Controller\Application\Set::setApplicationPath
     * @covers  Molajo\Controller\Application\Set::processRequestPath
     * @covers  Molajo\Controller\Application\Set::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application\Set::setApplicationBasePath
     * @covers  Molajo\Controller\Application\Base::__construct
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testSetApplicationAdmin()
    {
        // SETUP
        $query          = new QueryMock();
        $fieldhandler   = new FieldhandlerMock();
        $base_path      = 'admin/articles';
        $applications   = $this->getApplications();
        $model_registry = $this->getModelRegistry();

        $this->test_instance = new MockApplication(
            $query,
            $fieldhandler,
            $base_path,
            $applications,
            $model_registry
        );
        // End SETUP

        $this->test_instance->setApplication();

        $this->assertEquals(2, $this->test_instance->get('id'));
        $this->assertEquals('admin', $this->test_instance->get('name'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::verifySiteApplication
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationInstallation
     * @covers  Molajo\Controller\Application\Configuration::runConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::createConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::setCustomFields
     * @covers  Molajo\Controller\Application\Configuration::processCustomfieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application\Configuration::setCustomFieldValue
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application\Configuration::createCustomFieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application\Configuration::sanitize
     * @covers  Molajo\Controller\Application\Set::setApplicationPath
     * @covers  Molajo\Controller\Application\Set::processRequestPath
     * @covers  Molajo\Controller\Application\Set::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application\Set::setApplicationBasePath
     * @covers  Molajo\Controller\Application\Base::__construct
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testSetApplicationInstallation()
    {
        // SETUP
        $query          = new QueryMock();
        $fieldhandler   = new FieldhandlerMock();
        $base_path      = 'installation';
        $applications   = $this->getApplications();
        $model_registry = $this->getModelRegistry();

        $this->test_instance = new MockApplication(
            $query,
            $fieldhandler,
            $base_path,
            $applications,
            $model_registry
        );
        // End SETUP

        $this->test_instance->setApplication();

        $this->assertEquals(0, $this->test_instance->get('id'));
        $this->assertEquals('installation', $this->test_instance->get('name'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Application::setApplication
     * @covers  Molajo\Controller\Application::getConfiguration
     * @covers  Molajo\Controller\Application::verifySiteApplication
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationInstallation
     * @covers  Molajo\Controller\Application\Configuration::runConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::createConfigurationQuery
     * @covers  Molajo\Controller\Application\Configuration::setCustomFields
     * @covers  Molajo\Controller\Application\Configuration::processCustomfieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldsDataElement
     * @covers  Molajo\Controller\Application\Configuration::setCustomFieldValue
     * @covers  Molajo\Controller\Application\Configuration::getCustomfieldGroupData
     * @covers  Molajo\Controller\Application\Configuration::createCustomFieldGroup
     * @covers  Molajo\Controller\Application\Configuration::getConfigurationLineEnd
     * @covers  Molajo\Controller\Application\Configuration::sanitize
     * @covers  Molajo\Controller\Application\Set::setApplicationPath
     * @covers  Molajo\Controller\Application\Set::processRequestPath
     * @covers  Molajo\Controller\Application\Set::getApplicationArrayEntry
     * @covers  Molajo\Controller\Application\Set::setApplicationBasePath
     * @covers  Molajo\Controller\Application\Base::__construct
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testGetConfiguration()
    {
        // SETUP
        $query          = new QueryMock();
        $fieldhandler   = new FieldhandlerMock();
        $base_path      = 'admin/articles';
        $applications   = $this->getApplications();
        $model_registry = $this->getModelRegistry();

        $this->test_instance = new MockApplication(
            $query,
            $fieldhandler,
            $base_path,
            $applications,
            $model_registry
        );
        // End SETUP

        $this->test_instance->setApplication();

        $this->assertEquals(2, $this->test_instance->get('id'));
        $this->assertEquals('admin', $this->test_instance->get('name'));

//todo
        return $this;
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
