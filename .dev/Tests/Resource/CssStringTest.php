<?php
/**
 * Css String Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;
use stdClass;

/**
 * Css String Test
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
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::setAssetOptions
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipAssetString
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::setMethodOptions
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyDotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifySkipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipDuplicate
     * @covers  Molajo\Resource\Adapter\AssetCollection::getCollection
     * @covers  Molajo\Resource\Adapter\AssetCollection::testCollectionRow
     * @covers  Molajo\Resource\Adapter\AssetCollection::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AssetCollection::getDeferRequest
     * @covers  Molajo\Resource\Adapter\AssetBase::__construct
     * @covers  Molajo\Resource\Adapter\AssetBase::setClassProperties
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::setNamespace
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::exists
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::get
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::locateResourceNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\SetNamespace::appendNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::prependNamespace
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixDirectory
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrepareNamespacePath
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespaceFilename
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixFileExtensions
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMap
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapInstance
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::setResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapFileExtensions
     * @covers  Molajo\Resource\Adapter\Base::initialiseCacheVariables
     * @covers  Molajo\Resource\Adapter\Base::setScheme
     * @covers  Molajo\Resource\Adapter\Base::setResourceNamespace
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     * @covers  Molajo\Resource\Proxy::setNamespace
     * @covers  Molajo\Resource\Proxy::exists
     * @covers  Molajo\Resource\Proxy::get
     * @covers  Molajo\Resource\Proxy::getCollection
     * @covers  Molajo\Resource\Proxy::register
     * @covers  Molajo\Resource\Proxy::unregister
     * @covers  Molajo\Resource\Proxy::getClass
     * @covers  Molajo\Resource\Proxy\Scheme::__construct
     * @covers  Molajo\Resource\Proxy\Scheme::setScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getScheme
     * @covers  Molajo\Resource\Proxy\Scheme::setAdapterNamespaces
     * @covers  Molajo\Resource\Proxy\Scheme::saveNamespaceArray
     * @covers  Molajo\Resource\Proxy\Scheme::locateScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getUriScheme
     * @covers  Molajo\Resource\Proxy\Scheme::removeUriScheme
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

        $this->adapter_instance = new CssDeclarationsExtended(
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

        $this->proxy_instance->setScheme('Cssdeclarations', $this->adapter_instance, array());

        return $this;
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::setAssetOptions
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipAssetString
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::setMethodOptions
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyDotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifySkipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipDuplicate
     * @covers  Molajo\Resource\Adapter\AssetCollection::getCollection
     * @covers  Molajo\Resource\Adapter\AssetCollection::testCollectionRow
     * @covers  Molajo\Resource\Adapter\AssetCollection::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AssetCollection::getDeferRequest
     * @covers  Molajo\Resource\Adapter\AssetBase::__construct
     * @covers  Molajo\Resource\Adapter\AssetBase::setClassProperties
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::setNamespace
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::exists
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::get
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::locateResourceNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\SetNamespace::appendNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::prependNamespace
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixDirectory
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrepareNamespacePath
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespaceFilename
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixFileExtensions
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMap
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapInstance
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::setResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapFileExtensions
     * @covers  Molajo\Resource\Adapter\Base::initialiseCacheVariables
     * @covers  Molajo\Resource\Adapter\Base::setScheme
     * @covers  Molajo\Resource\Adapter\Base::setResourceNamespace
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     * @covers  Molajo\Resource\Proxy::setNamespace
     * @covers  Molajo\Resource\Proxy::exists
     * @covers  Molajo\Resource\Proxy::get
     * @covers  Molajo\Resource\Proxy::getCollection
     * @covers  Molajo\Resource\Proxy::register
     * @covers  Molajo\Resource\Proxy::unregister
     * @covers  Molajo\Resource\Proxy::getClass
     * @covers  Molajo\Resource\Proxy\Scheme::__construct
     * @covers  Molajo\Resource\Proxy\Scheme::setScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getScheme
     * @covers  Molajo\Resource\Proxy\Scheme::setAdapterNamespaces
     * @covers  Molajo\Resource\Proxy\Scheme::saveNamespaceArray
     * @covers  Molajo\Resource\Proxy\Scheme::locateScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getUriScheme
     * @covers  Molajo\Resource\Proxy\Scheme::removeUriScheme
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
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::setAssetOptions
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipAssetString
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::setMethodOptions
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyDotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifySkipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipDuplicate
     * @covers  Molajo\Resource\Adapter\AssetCollection::getCollection
     * @covers  Molajo\Resource\Adapter\AssetCollection::testCollectionRow
     * @covers  Molajo\Resource\Adapter\AssetCollection::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AssetCollection::getDeferRequest
     * @covers  Molajo\Resource\Adapter\AssetBase::__construct
     * @covers  Molajo\Resource\Adapter\AssetBase::setClassProperties
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::setNamespace
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::exists
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::get
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::locateResourceNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\SetNamespace::appendNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::prependNamespace
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixDirectory
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrepareNamespacePath
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespaceFilename
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixFileExtensions
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMap
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapInstance
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::setResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapFileExtensions
     * @covers  Molajo\Resource\Adapter\Base::initialiseCacheVariables
     * @covers  Molajo\Resource\Adapter\Base::setScheme
     * @covers  Molajo\Resource\Adapter\Base::setResourceNamespace
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     * @covers  Molajo\Resource\Proxy::setNamespace
     * @covers  Molajo\Resource\Proxy::exists
     * @covers  Molajo\Resource\Proxy::get
     * @covers  Molajo\Resource\Proxy::getCollection
     * @covers  Molajo\Resource\Proxy::register
     * @covers  Molajo\Resource\Proxy::unregister
     * @covers  Molajo\Resource\Proxy::getClass
     * @covers  Molajo\Resource\Proxy\Scheme::__construct
     * @covers  Molajo\Resource\Proxy\Scheme::setScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getScheme
     * @covers  Molajo\Resource\Proxy\Scheme::setAdapterNamespaces
     * @covers  Molajo\Resource\Proxy\Scheme::saveNamespaceArray
     * @covers  Molajo\Resource\Proxy\Scheme::locateScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getUriScheme
     * @covers  Molajo\Resource\Proxy\Scheme::removeUriScheme
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
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/css';
        $options['media']        = '';
        $options['conditional']  = '';
        $options['attributes']   = '';

        $this->proxy_instance->get('Cssdeclarations:\\', $options);

        $actual_results = $this->proxy_instance->getCollection('Cssdeclarations', $options);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::setAssetOptions
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipAssetString
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::setMethodOptions
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyDotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifySkipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipDuplicate
     * @covers  Molajo\Resource\Adapter\AssetCollection::getCollection
     * @covers  Molajo\Resource\Adapter\AssetCollection::testCollectionRow
     * @covers  Molajo\Resource\Adapter\AssetCollection::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AssetCollection::getDeferRequest
     * @covers  Molajo\Resource\Adapter\AssetBase::__construct
     * @covers  Molajo\Resource\Adapter\AssetBase::setClassProperties
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::setNamespace
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::exists
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::get
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::locateResourceNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\SetNamespace::appendNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::prependNamespace
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixDirectory
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrepareNamespacePath
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespaceFilename
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixFileExtensions
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMap
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapInstance
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::setResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapFileExtensions
     * @covers  Molajo\Resource\Adapter\Base::initialiseCacheVariables
     * @covers  Molajo\Resource\Adapter\Base::setScheme
     * @covers  Molajo\Resource\Adapter\Base::setResourceNamespace
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     * @covers  Molajo\Resource\Proxy::setNamespace
     * @covers  Molajo\Resource\Proxy::exists
     * @covers  Molajo\Resource\Proxy::get
     * @covers  Molajo\Resource\Proxy::getCollection
     * @covers  Molajo\Resource\Proxy::register
     * @covers  Molajo\Resource\Proxy::unregister
     * @covers  Molajo\Resource\Proxy::getClass
     * @covers  Molajo\Resource\Proxy\Scheme::__construct
     * @covers  Molajo\Resource\Proxy\Scheme::setScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getScheme
     * @covers  Molajo\Resource\Proxy\Scheme::setAdapterNamespaces
     * @covers  Molajo\Resource\Proxy\Scheme::saveNamespaceArray
     * @covers  Molajo\Resource\Proxy\Scheme::locateScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getUriScheme
     * @covers  Molajo\Resource\Proxy\Scheme::removeUriScheme
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testDuplicate()
    {
        // Results
        $expected_results = array();

        // Request String
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

        // Request String 1st time
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/css';
        $options['media']        = '';
        $options['conditional']  = '';
        $options['attributes']   = '';

        $this->proxy_instance->get('Cssdeclarations:\\', $options);

        // Request String 2nd time
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

        // Request String 2nd time
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/css';
        $options['media']        = '';
        $options['conditional']  = '';
        $options['attributes']   = '';

        $this->proxy_instance->get('Cssdeclarations:\\', $options);

        $actual_results = $this->proxy_instance->getCollection('Cssdeclarations', $options);

        $this->assertEquals($expected_results[0]->path_or_string, $actual_results[0]->path_or_string);
        $this->assertEquals($expected_results[0]->priority, $actual_results[0]->priority);
        $this->assertEquals($expected_results[0]->mimetype, $actual_results[0]->mimetype);
        $this->assertEquals($expected_results[0]->media, $actual_results[0]->media);
        $this->assertEquals($expected_results[0]->conditional, $actual_results[0]->conditional);
        $this->assertEquals($expected_results[0]->attributes, $actual_results[0]->attributes);
    }

    /**
     * @covers  Molajo\Resource\Adapter\Assets::handlePath
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFolder
     * @covers  Molajo\Resource\Adapter\Assets::addAssetFile
     * @covers  Molajo\Resource\Adapter\Assets::addAssetString
     * @covers  Molajo\Resource\Adapter\Assets::setAssetRow
     * @covers  Molajo\Resource\Adapter\Assets::setAssetOptions
     * @covers  Molajo\Resource\Adapter\Assets::filterOptionValue
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipAssetString
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::setMethodOptions
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyDotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyLanguageDirectionalFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifySkipFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFile
     * @covers  Molajo\Resource\Adapter\AssetSelection::verifyNotFileExtension
     * @covers  Molajo\Resource\Adapter\AssetSelection::skipDuplicate
     * @covers  Molajo\Resource\Adapter\AssetCollection::getCollection
     * @covers  Molajo\Resource\Adapter\AssetCollection::testCollectionRow
     * @covers  Molajo\Resource\Adapter\AssetCollection::getAssetPriorities
     * @covers  Molajo\Resource\Adapter\AssetCollection::getDeferRequest
     * @covers  Molajo\Resource\Adapter\AssetBase::__construct
     * @covers  Molajo\Resource\Adapter\AssetBase::setClassProperties
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::setNamespace
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::exists
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::get
     * @covers  Molajo\Resource\Adapter\NamespaceHandler::locateResourceNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::setNamespaceExists
     * @covers  Molajo\Resource\Adapter\SetNamespace::appendNamespace
     * @covers  Molajo\Resource\Adapter\SetNamespace::prependNamespace
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixes
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefix
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixDirectory
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrepareNamespacePath
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespaceFilename
     * @covers  Molajo\Resource\Adapter\HandleNamespacePrefixes::searchNamespacePrefixFileExtensions
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMap
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapInstance
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::setResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapPaths
     * @covers  Molajo\Resource\Adapter\HandleResourceMap::searchResourceMapFileExtensions
     * @covers  Molajo\Resource\Adapter\Base::initialiseCacheVariables
     * @covers  Molajo\Resource\Adapter\Base::setScheme
     * @covers  Molajo\Resource\Adapter\Base::setResourceNamespace
     * @covers  Molajo\Resource\Adapter\Cache::getConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::setConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::useConfigurationCache
     * @covers  Molajo\Resource\Adapter\Cache::getCache
     * @covers  Molajo\Resource\Adapter\Cache::setCache
     * @covers  Molajo\Resource\Adapter\Cache::deleteCache
     * @covers  Molajo\Resource\Adapter\Cache::clearCache
     * @covers  Molajo\Resource\Proxy::setNamespace
     * @covers  Molajo\Resource\Proxy::exists
     * @covers  Molajo\Resource\Proxy::get
     * @covers  Molajo\Resource\Proxy::getCollection
     * @covers  Molajo\Resource\Proxy::register
     * @covers  Molajo\Resource\Proxy::unregister
     * @covers  Molajo\Resource\Proxy::getClass
     * @covers  Molajo\Resource\Proxy\Scheme::__construct
     * @covers  Molajo\Resource\Proxy\Scheme::setScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getScheme
     * @covers  Molajo\Resource\Proxy\Scheme::setAdapterNamespaces
     * @covers  Molajo\Resource\Proxy\Scheme::saveNamespaceArray
     * @covers  Molajo\Resource\Proxy\Scheme::locateScheme
     * @covers  Molajo\Resource\Proxy\Scheme::getUriScheme
     * @covers  Molajo\Resource\Proxy\Scheme::removeUriScheme
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

        // Request string 1
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '500';
        $options['mimetype']     = 'text/css';
        $options['media']        = '';
        $options['conditional']  = '';
        $options['attributes']   = '';

        $this->proxy_instance->get('Cssdeclarations:\\', $options);

        // Request string 2
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
        $options                 = array();
        $options['asset_string'] = $row->path_or_string;
        $options['priority']     = '1';
        $options['mimetype']     = 'text/css';
        $options['media']        = '';
        $options['conditional']  = '';
        $options['attributes']   = '';

        $this->proxy_instance->get('Cssdeclarations:\\', $options);

        // Request collection
        $actual_results = $this->proxy_instance->getCollection('Cssdeclarations', $options);

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
class CssDeclarationsExtended extends Cssdeclarations implements ResourceInterface
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
