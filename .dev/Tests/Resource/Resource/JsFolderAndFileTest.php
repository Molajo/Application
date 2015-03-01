<?php
/**
 * Js Folder and File Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;
use stdClass;

/**
 * Js Folder and File Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class JsFolderAndFileTest extends \PHPUnit_Framework_TestCase
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
        $handler_options['mimetype']           = 'text/js';

        $this->adapter_instance = new JsExtended(
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

        $this->proxy_instance->setScheme('Js', $this->adapter_instance, array());

        $this->proxy_instance->setNamespace('Molajo\\', 'TestMedia/');

        return $this;
    }

    /**
     * @return  $this
     * @since   1.0.0
     */
    public function testSetClassProperties()
    {
        $this->assertEquals('ltr', $this->adapter_instance->getTestValue('language_direction'));
        $this->assertEquals(1, $this->adapter_instance->getTestValue('html5'));
        $this->assertEquals('/>', $this->adapter_instance->getTestValue('line_end'));
        $this->assertEquals('text/js', $this->adapter_instance->getTestValue('mimetype'));

        return $this;
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testFolder()
    {
        // Results
        $expected_results = array();

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/form.js';
        $row->priority       = '500';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/jquery.js';
        $row->priority       = '500';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/ltr-include.js';
        $row->priority       = '500';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        // input
        $path = __DIR__ . '/TestMedia/Js';

        $options             = array();
        $options['priority'] = '500';
        $options['mimetype'] = 'text/js';
        $options['defer']    = '';
        $options['async']    = '';

        $this->proxy_instance->get('Js:\\\Molajo\\Js', $options);

        $actual_results = $this->proxy_instance->getCollection('Js', $options);

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

        $this->assertEquals($expected_results[2]->path_or_string, $actual_results[2]->path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[2]->defer, $actual_results[2]->defer);
        $this->assertEquals($expected_results[2]->async, $actual_results[2]->async);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testDuplicateFiles()
    {
        // Results
        $expected_results = array();

        // 1
        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/form.js';
        $row->priority       = '500';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        $options             = array();
        $options['priority'] = '500';
        $options['mimetype'] = 'text/js';
        $options['defer']    = '';
        $options['async']    = '';

        $this->proxy_instance->get('Js:\\\Molajo\\Js\form.js', $options);

        // 2
        $this->proxy_instance->get('Js:\\\Molajo\\Js\form.js', $options);

        // 3
        $this->proxy_instance->get('Js:\\\Molajo\\Js\form.js', $options);

        // Verify results
        $actual_results = $this->proxy_instance->getCollection('Js', $options);

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
    public function testFiles()
    {
        // Results
        $expected_results = array();

        // 1
        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/form.js';
        $row->priority       = '500';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        $options             = array();
        $options['priority'] = '500';
        $options['mimetype'] = 'text/js';
        $options['defer']    = '';
        $options['async']    = '';

        $this->proxy_instance->get('Js:\\\Molajo\\Js\form.js', $options);

        // 2
        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/jquery.js';
        $row->priority       = '1';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        $options             = array();
        $options['priority'] = '1';
        $options['mimetype'] = 'text/js';
        $options['defer']    = '';
        $options['async']    = '';

        $this->proxy_instance->get('Js:\\\Molajo\\Js\jquery.js', $options);

        // 3
        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Js/ltr-include.js';
        $row->priority       = '1000';
        $row->mimetype       = 'text/js';
        $row->defer          = '';
        $row->async          = '';
        $expected_results[]  = $row;

        $options             = array();
        $options['priority'] = '1000';
        $options['mimetype'] = 'text/js';
        $options['defer']    = '';
        $options['async']    = '';

        $this->proxy_instance->get('Js:\\\Molajo\\Js\ltr-include.js', $options);

        // Verify results
        $actual_results = $this->proxy_instance->getCollection('Js', $options);

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[1]->defer, $actual_results[0]->defer);
        $this->assertEquals($expected_results[1]->async, $actual_results[0]->async);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[1]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[0]->defer, $actual_results[1]->defer);
        $this->assertEquals($expected_results[0]->async, $actual_results[1]->async);

        $this->assertEquals($expected_results[2]->path_or_string, $actual_results[2]->path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[2]->defer, $actual_results[2]->defer);
        $this->assertEquals($expected_results[2]->async, $actual_results[2]->async);
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
class JsExtended extends Js implements ResourceInterface
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
