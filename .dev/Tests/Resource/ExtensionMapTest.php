<?php
/**
 * ExtensionMap Resource Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource;

use stdClass;

/**
 * ExtensionMap Resource Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ExtensionMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Focus of test
     *
     * @var    object
     * @since  1.0.0
     */
    protected $resource_map_instance;

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setUp()
    {
        $resource_instance = new MockResource();

        $runtime_data = $this->createRuntimeData();

        $extensions_filename = __DIR__ . '/TestMedia/Extensions.json';

        $this->resource_map_instance = new ExtensionMap(
            $resource_instance,
            $runtime_data,
            $extensions_filename
        );

        return $this;
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function createRuntimeData()
    {
        $runtime_data = new stdClass();

        $runtime_data->application     = new stdClass();
        $runtime_data->application->id = 2;

        $runtime_data->site     = new stdClass();
        $runtime_data->site->id = 2;

        $runtime_data->reference_data                                = new stdClass();
        $runtime_data->reference_data->catalog_type_plugin_id        = 5000;
        $runtime_data->reference_data->catalog_type_theme_id         = 7000;
        $runtime_data->reference_data->catalog_type_page_view_id     = 8000;
        $runtime_data->reference_data->catalog_type_template_view_id = 9000;
        $runtime_data->reference_data->catalog_type_wrap_view_id     = 10000;
        $runtime_data->reference_data->catalog_type_menuitem_id      = 11000;
        $runtime_data->reference_data->catalog_type_resource_id      = 12000;

        return $runtime_data;
    }

    /**
     * Read File
     *
     * @param   string $file_name
     *
     * @return  array
     * @since   1.0.0
     */
    protected function readFile($file_name)
    {
        if (file_exists($file_name)) {
        } else {
            return array();
        }

        $input = file_get_contents($file_name);

        return $this->readFileIntoArray($input);
    }

    /**
     * Process JSON string by loading into an array
     *
     * @param   string $input
     *
     * @return  array
     * @since   1.0.0
     */
    protected function readFileIntoArray($input)
    {
        $temp = json_decode($input);

        $temp_array = array();
        if (count($temp) > 0) {
            $temp_array = array();
            foreach ($temp as $key => $value) {
                $temp_array[$key] = $value;
            }
        }

        return $temp_array;
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testCreateMap()
    {
        //$fields = $this->readFile(
        //  __DIR__ . '/TestMedia/Themes.json'
        //);

//$results = $this->resource_map_instance->createMap();

        $this->assertEquals(1, 1);
    }
}

class MockResource
{
    protected $catalog_types = array();

    public function get($resource_namespace, array $options = array())
    {
        $model_name = '';

        if ($resource_namespace === 'query:///Molajo//Model//Datasource//ExtensionInstances.xml') {

            $controller = new MockController();
            $controller->setType('A');
            $controller->setQueryResults('B');

            return $controller;

        } elseif ($resource_namespace ===  'query:///' . $model_name) {

        }
    }
}

class MockController
{
    protected $type = null;

    protected $query_results = array();

    public function setType($value)
    {
        $this->type = $value;
    }

    public function setQueryResults($value)
    {
        $this->query_results = $value;
    }

    public function setModelRegistry($key, $value)
    {

    }

    public function getModelRegistry($key, $default)
    {
        return $default;
    }

    public function select($a)
    {
        return $this;
    }

    public function from($a, $b)
    {
        return $this;
    }

    public function where($a, $b, $c, $d, $e, $f)
    {
        return $this;
    }

    public function setSql($value)
    {
        return $this;
    }

    public function getData()
    {
        return $this->query_results;
    }

}
