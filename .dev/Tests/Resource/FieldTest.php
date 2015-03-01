<?php
/**
 * Field Resource Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;

/**
 * Field Resource Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class FieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get Cache Callback
     *
     * @var    callable
     * @since  1.0.0
     */
    protected $get_cache_callback;

    /**
     * Set Cache Callback
     *
     * @var    callable
     * @since  1.0.0
     */
    protected $set_cache_callback;

    /**
     * Delete Cache Callback
     *
     * @var    callable
     * @since  1.0.0
     */
    protected $delete_cache_callback;

    /**
     * Focus of test
     *
     * @var    object
     * @since  1.0.0
     */
    protected $proxy_instance;

    /**
     * Adapter Instance
     *
     * @var    object
     * @since  1.0.0
     */
    protected $adapter_instance;

    /**
     * Get Cache Value
     *
     * @param   string $cache_key
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function getCache($cache_key, $options)
    {
        return $this;
    }

    /**
     * Set Cache Value
     *
     * @param   string $cache_key
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setCache($cache_key, $options)
    {
        return $this;
    }

    /**
     * Delete Cache Key or Clear Cache
     *
     * @param   string $cache_key
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function deleteCache($cache_key, $options)
    {
        return $this;
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setUp()
    {
        $this->get_cache_callback = function ($cache_key, array $options = array()) {
            return $this->getCache($cache_key, $options);
        };

        $this->set_cache_callback = function ($cache_key, array $options = array()) {
            return $this->setCache($cache_key, $options);
        };

        $this->delete_cache_callback = function ($cache_key, array $options = array()) {
            return $this->deleteCache($cache_key, $options);
        };

        $cache_callbacks                          = array();
        $cache_callbacks['get_cache_callback']    = $this->get_cache_callback;
        $cache_callbacks['set_cache_callback']    = $this->set_cache_callback;
        $cache_callbacks['delete_cache_callback'] = $this->delete_cache_callback;

        $fields = $this->readFile(
            __DIR__ . '/TestMedia/Fields.json'
        );

        $handler_options           = array();
        $handler_options['fields'] = $fields;

        $this->adapter_instance = new FieldExtended(
            __DIR__,
            array(),
            array(),
            array(),
            $cache_callbacks,
            $handler_options
        );

        $class  = 'Molajo\\Resource\\Scheme';
        $scheme = new $class();

        $class                = 'Molajo\\Resource\\Proxy';
        $this->proxy_instance = new $class($scheme);

        $this->proxy_instance->setScheme('Field', $this->adapter_instance, array());

        $this->proxy_instance->setNamespace('Molajo\\', 'TestMedia/');

        return $this;
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
    public function testSetClassProperties()
    {
        $fields = $this->readFile(
            __DIR__ . '/TestMedia/Fields.json'
        );

        $this->assertEquals($fields, $this->adapter_instance->getTestValue('fields'));

        return $this;
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testFieldExists()
    {
        // Results
        $expected_results             = array();
        $expected_results['name']     = 'action_id';
        $expected_results['type']     = 'integer';
        $expected_results['length']   = null;
        $expected_results['null']     = 0;
        $expected_results['default']  = '';
        $expected_results['unique']   = null;
        $expected_results['identity'] = null;
        $expected_results['values']   = null;
        $expected_results['display']  = null;
        $expected_results['cols']     = null;
        $expected_results['rows']     = null;
        $expected_results['hidden']   = null;
        $expected_results['datalist'] = null;
        $expected_results['multiple'] = null;
        $expected_results['size']     = null;
        $expected_results['locked']   = null;

        $actual_results = $this->proxy_instance->get('field://action_id');

        $this->assertEquals($expected_results, $actual_results);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testFieldDoesNotExist()
    {
        $actual_results = $this->proxy_instance->get('field://does_not_exist');

        $this->assertEquals(null, $actual_results);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testCollection()
    {
        $actual_results = $this->proxy_instance->getCollection('field');

        $this->assertEquals(54, count($actual_results));
    }
}

/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class FieldExtended extends Field implements ResourceInterface
{
    /**
     * Support Testing
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function getTestValue($key)
    {
        return $this->$key;
    }
}
