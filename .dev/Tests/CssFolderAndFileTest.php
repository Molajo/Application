<?php
/**
 * Css Folder and File Test
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
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicateFile
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
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

        $this->test_instance = new CssExtended(
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
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicateFile
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
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
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicateFile
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
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
    public function testFolder()
    {
        // Results
        $expected_results = array();

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/ltrinclude.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/normalize.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        // input
        $path = __DIR__ . '/TestMedia/Css';

        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        $actual_results = $this->test_instance->getTestValue('asset_array');

        $this->assertEquals($expected_results[0]->css_path_or_string, $actual_results[0]->css_path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[1]->css_path_or_string, $actual_results[1]->css_path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[1]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[1]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[1]->attributes, $actual_results[1]->attributes);

        $this->assertEquals($expected_results[2]->css_path_or_string, $actual_results[2]->css_path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[2]->media, $actual_results[2]->media);
        $this->assertEquals($expected_results[2]->conditional, $actual_results[2]->conditional);
        $this->assertEquals($expected_results[2]->attributes, $actual_results[2]->attributes);
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
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicateFile
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
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
    public function testDuplicates()
    {
        // Results
        $expected_results = array();

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/ltrinclude.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/normalize.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        // input
        $path = __DIR__ . '/TestMedia/Css';

        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        // input
        $path = __DIR__ . '/TestMedia/Css';

        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        $actual_results = $this->test_instance->getTestValue('asset_array');

        $this->assertEquals($expected_results[0]->css_path_or_string, $actual_results[0]->css_path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[1]->css_path_or_string, $actual_results[1]->css_path_or_string);
        $this->assertEquals($expected_results[1]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[1]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[1]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[1]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[1]->attributes, $actual_results[1]->attributes);

        $this->assertEquals($expected_results[2]->css_path_or_string, $actual_results[2]->css_path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[2]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[2]->mimetype);
        $this->assertEquals($expected_results[2]->media, $actual_results[2]->media);
        $this->assertEquals($expected_results[2]->conditional, $actual_results[2]->conditional);
        $this->assertEquals($expected_results[2]->attributes, $actual_results[2]->attributes);
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
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicateFile
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
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
    public function testFile()
    {
        // Results
        $expected_results = array();

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]          = $row;

        // input
        $path = __DIR__ . '/TestMedia/Css/Customize.css';

        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        $actual_results = $this->test_instance->getTestValue('asset_array');

        $this->assertEquals($expected_results[0]->css_path_or_string, $actual_results[0]->css_path_or_string);
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
     * @covers  Molajo\Resource\Adapter\Assets::skipDuplicateFile
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
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
    public function testPriorityCollection()
    {
        // Results
        $expected_results = array();

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/Customize.css';
        $row->priority           = '100';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]      = $row;

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/normalize.css';
        $row->priority           = '500';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]      = $row;

        $row                     = new stdClass();
        $row->css_path_or_string = __DIR__ . '/TestMedia/Css/ltrinclude.css';
        $row->priority           = '10';
        $row->mimetype           = 'text/css';
        $row->media              = '';
        $row->conditional        = '';
        $row->attributes         = 'The cow jumped over the moon.';
        $expected_results[]      = $row;

        // File 1
        $path = __DIR__ . '/TestMedia/Css/Customize.css';

        $options                = array();
        $options['priority']    = '100';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        // File 2
        $path = __DIR__ . '/TestMedia/Css/normalize.css';

        $options                = array();
        $options['priority']    = '500';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        // File 3
        $path = __DIR__ . '/TestMedia/Css/ltrinclude.css';

        $options                = array();
        $options['priority']    = '10';
        $options['mimetype']    = 'text/css';
        $options['media']       = '';
        $options['conditional'] = '';
        $options['attributes']  = array('The', 'cow', 'jumped', 'over', 'the', 'moon.');

        $this->test_instance->handlePath('css', $path, $options);

        $actual_results = $this->test_instance->getCollection('css');

        $this->assertEquals($expected_results[2]->css_path_or_string, $actual_results[0]->css_path_or_string);
        $this->assertEquals($expected_results[2]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[2]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[2]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[2]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[2]->attributes, $actual_results[0]->attributes);

        $this->assertEquals($expected_results[0]->css_path_or_string, $actual_results[1]->css_path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[1]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[1]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[1]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[1]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[1]->attributes);

        $this->assertEquals($expected_results[1]->css_path_or_string, $actual_results[2]->css_path_or_string);
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
class CssExtended extends Css
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
