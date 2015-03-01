<?php
/**
 * Js String Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;
use stdClass;

/**
 * Js String Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class JsStringTest extends \PHPUnit_Framework_TestCase
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
     * Proxy
     *
     * @var    object
     * @since  1.0.0
     */
    protected $proxy_instance;

    /**
     * Adapter
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

        $handler_options                       = array();
        $handler_options['language_direction'] = 'ltr';
        $handler_options['html5']              = 1;
        $handler_options['line_end']           = '/>';
        $handler_options['mimetype']           = 'text/css';

        $this->adapter_instance = new JsDeclarationsExtended(
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

        $this->proxy_instance->setScheme('Jsdeclarations', $this->adapter_instance, array());

        return $this;
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testSetClassProperties()
    {
        $this->assertEquals('ltr', $this->adapter_instance->getTestValue('language_direction'));
        $this->assertEquals(1, $this->adapter_instance->getTestValue('html5'));
        $this->assertEquals('/>', $this->adapter_instance->getTestValue('line_end'));
        $this->assertEquals('text/css', $this->adapter_instance->getTestValue('mimetype'));

        return $this;
    }

    /**
     * @return  $this
     * @since   1.0.0
     */
    public function testString()
    {
        // Results
        $expected_results = array();

        $row = new stdClass();
        $row->path_or_string
                            = '$(document).ready(function () {

    function submitform() {
        document.Grid.submit();
    }
});';
        $row->priority      = '500';
        $row->mimetype      = 'text/js';
        $row->defer         = '';
        $row->async         = '';
        $expected_results[] = $row;

        // input
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = '';
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // Verify results
        $actual_results = $this->proxy_instance->getCollection('Jsdeclarations', $options);

        $this->assertEquals(1, count($actual_results));

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->defer, $actual_results[0]->defer);
        $this->assertEquals($expected_results[0]->async, $actual_results[0]->async);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testEmptyString()
    {
        // Results
        $expected_results = array();

        $row                 = new stdClass();
        $row->path_or_string = '';
        $row->priority       = '500';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        // input
        $options                 = array();
        $options['asset_string'] = '';
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = '';
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // Verify results
        $actual_results = $this->proxy_instance->getCollection('Jsdeclarations', $options);

        $this->assertEquals(0, count($actual_results));
    }

    /**
     * @return  $this
     * @since   1.0.0
     */
    public function testDuplicate()
    {
        // Results
        $expected_results = array();

        $row = new stdClass();
        $row->path_or_string
                            = '$(document).ready(function () {

    function submitform() {
        document.Grid.submit();
    }
});';
        $row->priority      = '500';
        $row->mimetype      = 'text/js';
        $row->defer         = 0;
        $row->async         = '';
        $expected_results[] = $row;

        // 1
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = 0;
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);


        // 2
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = 0;
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // 3
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = 0;
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // Verify results
        $actual_results = $this->proxy_instance->getCollection('Jsdeclarations', array('defer', 0));

        $this->assertEquals(1, count($actual_results));

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->defer, $actual_results[0]->defer);
        $this->assertEquals($expected_results[0]->async, $actual_results[0]->async);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testMultipleString()
    {
        // Results
        $expected_results = array();

        // String 1
        $row = new stdClass();
        $row->path_or_string
                            = '$(document).ready(function () {

    function submitform() {
        document.Grid.submit();
    }
});';
        $row->priority      = '500';
        $row->mimetype      = 'text/js';
        $row->defer         = '';
        $row->async         = '';
        $expected_results[] = $row;

        // input
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = '';
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // String 2
        $row = new stdClass();
        $row->path_or_string
                            = '$(document).ready(function () {

    function doesnotmatch() {
        document.Grid.submit();
    }
});';
        $row->priority      = '500';
        $row->mimetype      = 'text/js';
        $row->defer         = '';
        $row->async         = '';
        $expected_results[] = $row;

        // input
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = '';
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // Verify results
        $actual_results = $this->proxy_instance->getCollection('Jsdeclarations', array('defer', 0));

        $this->assertEquals(2, count($actual_results));

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->defer, $actual_results[0]->defer);
        $this->assertEquals($expected_results[0]->async, $actual_results[0]->async);

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[1]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[1]->defer, $actual_results[1]->defer);
        $this->assertEquals($expected_results[1]->async, $actual_results[1]->async);
    }

    /**
     * @return  $this
     * @since   1.0.0
     */
    public function testDefer()
    {
        // Results
        $expected_results = array();

        // String 1
        $row = new stdClass();
        $row->path_or_string
                            = '$(document).ready(function () {

    function submitform() {
        document.Grid.submit();
    }
});';
        $row->priority      = '500';
        $row->mimetype      = 'text/js';
        $row->defer         = 1;
        $row->async         = '';
        $expected_results[] = $row;

        // input
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = 1;
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // String 2
        $row = new stdClass();
        $row->path_or_string
                            = '$(document).ready(function () {

    function doesnotmatch() {
        document.Grid.submit();
    }
});';
        $row->priority      = '500';
        $row->mimetype      = 'text/js';
        $row->defer         = '';
        $row->async         = '';

        $expected_results[] = $row;

        // input
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/js';
        $options['defer']        = '';
        $options['async']        = '';

        $this->proxy_instance->get('Jsdeclarations:\\', $options);

        // Verify results defer
        $actual_results = $this->proxy_instance->getCollection('Jsdeclarations', array('defer' => 1));

        $this->assertEquals(1, count($actual_results));

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->defer, $actual_results[0]->defer);
        $this->assertEquals($expected_results[0]->async, $actual_results[0]->async);


        // Verify results NO defer
        $actual_results = $this->proxy_instance->getCollection('Jsdeclarations');

        $this->assertEquals(1, count($actual_results));

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[1]->defer, $actual_results[0]->defer);
        $this->assertEquals($expected_results[1]->async, $actual_results[0]->async);
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
class JsDeclarationsExtended extends Jsdeclarations implements ResourceInterface
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
