<?php
/**
 * Css Folder and File Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;
use stdClass;

/**
 * Css Folder and File Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class CssFolderAndFileTest extends \PHPUnit_Framework_TestCase
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

        $handler_options                       = array();
        $handler_options['language_direction'] = 'ltr';
        $handler_options['html5']              = 1;
        $handler_options['line_end']           = '/>';
        $handler_options['mimetype']           = 'text/css';

        $this->adapter_instance = new CssExtended(
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

        $this->proxy_instance->setScheme('Css', $this->adapter_instance, array());

        $this->proxy_instance->setNamespace('Molajo\\', 'TestMedia/');

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
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testFolder()
    {
        // Results
        $expected_results = array();

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/ltrinclude.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/normalize.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        // input
        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');
        $options['scheme_name'] = 'css';

        $this->proxy_instance->get('Css:\\\Molajo\\Css', $options);

        $actual_results = $this->proxy_instance->getCollection('css', $options);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[1]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[1]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[1]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[1]->attributes, $actual_results[1]->attributes);

        $this->assertEquals($expected_results[2]->path_or_string, $actual_results[2]->path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[2]->media, $actual_results[2]->media);
        $this->assertEquals($expected_results[2]->conditional, $actual_results[2]->conditional);
        $this->assertEquals($expected_results[2]->attributes, $actual_results[2]->attributes);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testDuplicates()
    {
        // Results
        $expected_results = array();

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/ltrinclude.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/normalize.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        // request folder first time
        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->proxy_instance->get('Css:\\\Molajo\\Css', $options);

        // request the same folder again
        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->proxy_instance->get('Css:\\\Molajo\\Css', $options);

        $actual_results = $this->proxy_instance->getCollection('css', $options);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[1]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[1]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[1]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[1]->attributes, $actual_results[1]->attributes);

        $this->assertEquals($expected_results[2]->path_or_string, $actual_results[2]->path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[2]->media, $actual_results[2]->media);
        $this->assertEquals($expected_results[2]->conditional, $actual_results[2]->conditional);
        $this->assertEquals($expected_results[2]->attributes, $actual_results[2]->attributes);
    }

    /**
     * @return  $this
     * @since   1.0.0
     */
    public function testFile()
    {
        // Results
        $expected_results = array();

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';

        $expected_results[]  = $row;

        // Request specific file
        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->proxy_instance->get('Css:\\\Molajo\\Css\\Customize.css', $options);

        $actual_results = $this->proxy_instance->getCollection('css', $options);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);
    }

    /**
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testPriorityCollection()
    {
        // Results
        $expected_results = array();

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority       = '100';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/normalize.css';
        $row->priority       = '500';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        $row                 = new stdClass();
        $row->path_or_string = __DIR__ . '/TestMedia/Css/ltrinclude.css';
        $row->priority       = '10';
        $row->mimetype       = 'text/css';
        $row->media          = '';
        $row->conditional    = '';
        $row->attributes     = 'The cow jumped over the moon.';
        $expected_results[]  = $row;

        // Request File 1
        $options                = array();
        $options['priority']    = '100';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->proxy_instance->get('Css:\\\Molajo\\Css\\Customize.css', $options);

        // Request File 2
        $path = __DIR__ . '/TestMedia/Css/normalize.css';

        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->proxy_instance->get('Css:\\\Molajo\\Css\\normalize.css', $options);

        // Request File 3
        $path = __DIR__ . '/TestMedia/Css/ltrinclude.css';

        $options                = array();
        $options['priority']    = '10';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->proxy_instance->get('Css:\\\Molajo\\Css\\ltrinclude.css', $options);

        // Get collection
        $actual_results = $this->proxy_instance->getCollection('css', $options);

        $this->assertEquals($expected_results[2]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[2]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[2]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[2]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[1]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[1]->attributes);

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[2]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[1]->media, $actual_results[2]->media);
        $this->assertEquals($expected_results[1]->conditional, $actual_results[2]->conditional);
        $this->assertEquals($expected_results[1]->attributes, $actual_results[2]->attributes);
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
class CssExtended extends Css implements ResourceInterface
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
