<?php
/**
 * Css String Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource\Adapter;

use stdClass;

/**
 * Css Folder and File Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class CssStringTest extends \PHPUnit_Framework_TestCase
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
    protected $test_instance;

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
     * @covers  Molajo\Resource\Adapter\Assets::__construct
     * @covers  Molajo\Resource\Adapter\Assets::setClassProperties
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::getCollection
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::skipFile
     * @covers  Molajo\Resource\Adapter\Assets::setMethodOptions
     * @covers  Molajo\Resource\Adapter\Assets::verifyDotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\Assets::verifySkipFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicate
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::skipAssetString
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\Assets::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::instantiateCache
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::appendNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::prependNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::get
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchResourceMap
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyFileExists
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
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

        $this->test_instance = new CssDeclarationsExtended(
            __DIR__,
            array(),
            array(),
            array(),
            $cache_callbacks,
            $handler_options
        );

        $this->test_instance->forceType();

        return $this;
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::__construct
     * @covers  Molajo\Resource\Adapter\Assets::setClassProperties
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::getCollection
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::skipFile
     * @covers  Molajo\Resource\Adapter\Assets::setMethodOptions
     * @covers  Molajo\Resource\Adapter\Assets::verifyDotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\Assets::verifySkipFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicate
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::skipAssetString
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\Assets::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::instantiateCache
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::appendNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::prependNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::get
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchResourceMap
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyFileExists
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testSetClassProperties()
    {
        $this->assertEquals('ltr', $this->test_instance->getTestValue('language_direction'));
        $this->assertEquals(1, $this->test_instance->getTestValue('html5'));
        $this->assertEquals('/>', $this->test_instance->getTestValue('line_end'));
        $this->assertEquals('text/css', $this->test_instance->getTestValue('mimetype'));

        return $this;
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::__construct
     * @covers  Molajo\Resource\Adapter\Assets::setClassProperties
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::getCollection
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::skipFile
     * @covers  Molajo\Resource\Adapter\Assets::setMethodOptions
     * @covers  Molajo\Resource\Adapter\Assets::verifyDotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\Assets::verifySkipFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicate
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::skipAssetString
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\Assets::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::instantiateCache
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::appendNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::prependNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::get
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchResourceMap
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyFileExists
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testString()
    {
        // Results
        $expected_results = array();

        $row = new stdClass();
        $row->path_or_string
                            = '/*! Customize.css v 1 | MIT License */

/*! Grid row */
.odd {
    background-color: #DBDBDB;
    padding-top: .5em
}

.even {
    padding-top: .5em
}

.edit-title {
}

.edit-editor {
}

.edit-foooter {
}

.edit-sidebar1, .edit-sidebar2, .edit-sidebar3 {
}

.order-down, .order-up {
    padding-right: 5px
}

.fi-star {
    color: gold;
    font-weight: bold;
    font-size: 1.5rem;
    text-align: center
}';
        $row->priority      = '500';
        $row->mimetype      = 'text/css';
        $row->media         = '';
        $row->conditional   = '';
        $row->attributes    = '';
        $expected_results[] = $row;

        // input
        $path = __DIR__ . '/TestMedia/Css';

        $options                = array();
        $options['asset_string']  = $row->path_or_string;
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = '';

        $this->test_instance->handlePath('css', '', $options);

        $actual_results = $this->test_instance->getTestValue('asset_array');

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::__construct
     * @covers  Molajo\Resource\Adapter\Assets::setClassProperties
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::getCollection
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::skipFile
     * @covers  Molajo\Resource\Adapter\Assets::setMethodOptions
     * @covers  Molajo\Resource\Adapter\Assets::verifyDotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\Assets::verifySkipFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicate
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::skipAssetString
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\Assets::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::instantiateCache
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::appendNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::prependNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::get
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchResourceMap
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyFileExists
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testDuplicate()
    {
        // Results
        $expected_results = array();

        // 1
        $row = new stdClass();
        $row->path_or_string
                            = '/*! Customize.css v 1 | MIT License */

/*! Grid row */
.odd {
    background-color: #DBDBDB;
    padding-top: .5em
}

.even {
    padding-top: .5em
}

.edit-title {
}

.edit-editor {
}

.edit-foooter {
}

.edit-sidebar1, .edit-sidebar2, .edit-sidebar3 {
}

.order-down, .order-up {
    padding-right: 5px
}

.fi-star {
    color: gold;
    font-weight: bold;
    font-size: 1.5rem;
    text-align: center
}';
        $row->priority      = '500';
        $row->mimetype      = 'text/css';
        $row->media         = '';
        $row->conditional   = '';
        $row->attributes    = '';
        $expected_results[] = $row;

        // input
        $path = __DIR__ . '/TestMedia/Css';

        $options                = array();
        $options['asset_string']  = $row->path_or_string;
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = '';

        $this->test_instance->handlePath('css', '', $options);

        // 2
        $row = new stdClass();
        $row->path_or_string
                            = '/*! Customize.css v 1 | MIT License */

/*! Grid row */
.odd {
    background-color: #DBDBDB;
    padding-top: .5em
}

.even {
    padding-top: .5em
}

.edit-title {
}

.edit-editor {
}

.edit-foooter {
}

.edit-sidebar1, .edit-sidebar2, .edit-sidebar3 {
}

.order-down, .order-up {
    padding-right: 5px
}

.fi-star {
    color: gold;
    font-weight: bold;
    font-size: 1.5rem;
    text-align: center
}';
        $row->priority      = '500';
        $row->mimetype      = 'text/css';
        $row->media         = '';
        $row->conditional   = '';
        $row->attributes    = '';
        $expected_results[] = $row;

        // input
        $path = __DIR__ . '/TestMedia/Css';

        $options                = array();
        $options['asset_string']  = $row->path_or_string;
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = '';

        $this->test_instance->handlePath('css', '', $options);

        $actual_results = $this->test_instance->getTestValue('asset_array');

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::__construct
     * @covers  Molajo\Resource\Adapter\Assets::setClassProperties
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::getCollection
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::skipFile
     * @covers  Molajo\Resource\Adapter\Assets::setMethodOptions
     * @covers  Molajo\Resource\Adapter\Assets::verifyDotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\Assets::verifySkipFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFile
     * @covers  Molajo\Resource\Adapter\Assets::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicate
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::skipAssetString
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\Assets::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::instantiateCache
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::appendNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::prependNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::get
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::searchResourceMap
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyNamespace
     * @covers  Molajo\Resource\Adapter\AbstractAdapter::verifyFileExists
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testMultipleString()
    {
        // Results
        $expected_results = array();

        // ONE
        $row = new stdClass();
        $row->path_or_string
                            = '/**
 * Correct `block` display not defined for any HTML5 element in IE 8/9.
 * Correct `block` display not defined for `details` or `summary` in IE 10/11 and Firefox.
 * Correct `block` display not defined for `main` in IE 11.
 */

article,
aside,
details,
figcaption,
figure,
footer,
header,
hgroup,
main,
nav,
section,
summary {
  display: block;
}';
        $row->priority      = '500';
        $row->mimetype      = 'text/css';
        $row->media         = '';
        $row->conditional   = '';
        $row->attributes    = '';
        $expected_results[] = $row;

        // Call 1
        $options                = array();
        $options['asset_string']  = $row->path_or_string;
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = '';

        $this->test_instance->handlePath('css', '', $options);

        // TWO
        $row = new stdClass();
        $row->path_or_string
                            = '
/**
 * 1. Correct `inline-block` display not defined in IE 8/9.
 * 2. Normalize vertical alignment of `progress` in Chrome, Firefox, and Opera.
 */

audio,
canvas,
progress,
video {
  display: inline-block; /* 1 */
  vertical-align: baseline; /* 2 */
}';
        $row->priority      = '1';
        $row->mimetype      = 'text/css';
        $row->media         = '';
        $row->conditional   = '';
        $row->attributes    = '';
        $expected_results[] = $row;

        // Call 2
        $options                = array();
        $options['asset_string']  = $row->path_or_string;
        $options['priority']    = '1';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = '';

        $this->test_instance->handlePath('css', '', $options);

        $actual_results = $this->test_instance->getCollection('css');

        $this->assertEquals($expected_results[1]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[1]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[1]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[1]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[1]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[1]->attributes);
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
class CssDeclarationsExtended extends CssDeclarations
{
    public function forceType()
    {
        $this->asset_type = 'css';

        if ($this->asset_type === 'css') {
            $this->asset_options = $this->asset_options_by_type['css'];
        } else {
            $this->asset_options = $this->asset_options_by_type['js'];
        }
    }

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
