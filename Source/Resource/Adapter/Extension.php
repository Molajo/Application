<?php
/**
 * Extension Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\AdapterInterface;
use CommonApi\Exception\RuntimeException;
use Exception;

/**
 * Extension Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class Extension extends AbstractAdapter implements AdapterInterface
{
    /**
     * Rendering Extensions
     *
     * @var    object
     * @since  1.0.0
     */
    protected $extensions = null;

    /**
     * Extension Object
     *
     * @var    object
     * @since  1.0.0
     */
    protected $extension = null;

    /**
     * Extension Path
     *
     * @var    string
     * @since  1.0.0
     */
    protected $extension_path = null;

    /**
     * Parameters
     *
     * @var    object
     * @since  1.0.0
     */
    protected $parameters = null;

    /**
     * Resource Instance to retrieve CSS and JS files
     *
     * @var    object
     * @since  1.0.0
     */
    protected $resource;

    /**
     * Catalog Type Id
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_id = null;

    /**
     * Catalog Type Priority
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_priority = null;

    /**
     * Default Partial Path
     *
     * @var    string
     * @since  1.0.0
     */
    protected $default_partial_path = null;

    /**
     * Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $file_name = null;

    /**
     * Constructor
     *
     * @param  string $base_path
     * @param  array  $resource_map
     * @param  array  $namespace_prefixes
     * @param  array  $valid_file_extensions
     * @param  array  $cache_callbacks
     * @param  array  $handler_options
     *
     * @since  1.0.0
     */
    public function __construct(
        $base_path = null,
        array $resource_map = array(),
        array $namespace_prefixes = array(),
        array $valid_file_extensions = array(),
        array $cache_callbacks = array(),
        array $handler_options = array()
    ) {
        parent::__construct(
            $base_path,
            $resource_map,
            $namespace_prefixes,
            $valid_file_extensions,
            $cache_callbacks
        );

        $this->setHandlerOptions($handler_options);
    }

    /**
     * Set Class properties using Handler Options array
     *
     * @param   array  $handler_options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setHandlerOptions(array $handler_options = array())
    {
        $this->extensions            = $handler_options['extensions'];
        $this->resource              = $handler_options['resource'];
        $this->catalog_type_id       = $handler_options['catalog_type_id'];
        $this->catalog_type_priority = $handler_options['catalog_type_priority'];
        $this->default_partial_path  = $handler_options['default_partial_path'];
        $this->file_name             = $handler_options['file_name'];

        return $this;
    }

    /**
     * Locates resource for extension
     *
     * @param   string $resource_namespace
     * @param   bool   $multiple
     *
     * @return  string
     * @since   1.0.0
     */
    public function get($resource_namespace, $multiple = false)
    {
        $extension = $this->getExtensionId($resource_namespace);
        $temp      = substr($resource_namespace, 0, strrpos($resource_namespace, '/') - 1);
        $alias     = $this->getExtensionAlias($extension);
        $namespace = $temp . '//' . $alias;

        $this->extension = $this->extensions->extensions[$this->catalog_type_id]->extensions[$extension];

        return $this->get($namespace);
    }

    /**
     * Get Extension expressed as primary key
     *
     * @param   string  $resource_namespace
     *
     * @return  string
     * @since   1.0.0
     */
    protected function getExtensionId($resource_namespace)
    {
        $extension = substr($resource_namespace, strrpos($resource_namespace, '/') + 1, 9999);

        $test = $extension;

        if (is_numeric($test) && (int)$test == $extension) {
            return $extension;
        }

        return $this->getExtensionAlias($extension);
    }

    /**
     * Get Alias for Extension
     *
     * @param   string  $extension
     *
     * @return  string
     * @since   1.0.0
     */
    protected function getExtensionAlias($extension)
    {
        $test = strtolower($extension);

        if (isset($this->extensions->extensions[$this->catalog_type_id]->ids[$test])) {
            $alias = $this->extensions->extensions[$this->catalog_type_id]->ids[$test];
        } else {
            $alias = $extension;
        }

        return $alias;
    }

    /**
     * Search compiled namespace map for resource namespace
     *
     * @param   string $resource_namespace
     *
     * @return  string|false
     * @since   1.0.0
     */
    protected function searchResourceMap($resource_namespace, $multiple = false)
    {
        return $this->searchResourceMapExtension($resource_namespace, $this->default_partial_path, $this->file_name);
    }

    /**
     * Search compiled namespace map for resource namespace
     *
     * @param   string $resource_namespace
     * @param   string $default_partial_path
     * @param   string $file_name
     *
     * @return  string|false
     * @since   1.0.0
     */
    protected function searchResourceMapExtension($resource_namespace, $default_partial_path, $file_name = '')
    {
        if (isset($this->resource_map[strtolower($resource_namespace)])) {
            return $this->searchResourceMapExtensionMap($resource_namespace, $file_name);
        }

        $path = $this->base_path . $default_partial_path . ucfirst(strtolower($this->extension->alias));

        $this->extension_path = $path;

        return $this->setResourceMapFileName($path, $file_name);
    }

    /**
     * Search compiled namespace map for resource namespace
     *
     * @param   string $resource_namespace
     * @param   string $file_name
     *
     * @return  string|false
     * @since   1.0.0
     */
    protected function searchResourceMapExtensionMap($resource_namespace, $file_name)
    {
        $paths = $this->resource_map[strtolower($resource_namespace)];

        if (is_array($paths)) {
        } else {
            $paths = array($paths);
        }

        $include_path = '';

        foreach ($paths as $path) {
            $include_path = $this->setResourceMapFileName($path, $file_name);

            break;
        }

        return $include_path;
    }

    /**
     * Set the return path + file_name (if needed)
     *
     * @param   string $path
     * @param   string $file_name
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setResourceMapFileName($path, $file_name = '')
    {
        if ($file_name === '') {
            $include_path = $path;
        } else {
            $include_path = $path . '/' . $file_name;
        }

        return $include_path;
    }

    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $scheme
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  object
     * @since   1.0.0
     */
    public function handlePath($scheme, $located_path, array $options = array())
    {
        $this->checkFileExists($located_path);

        $options             = array();
        $options['priority'] = $this->catalog_type_priority;

        $this->setExtensionAsset('Js', $located_path . '/Js', $options);

        $this->setExtensionAsset('Css', $located_path . '/Css', $options);

        return $this->extension;
    }

    /**
     * Check if File Exists
     *
     * @param   string $located_path
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function checkFileExists($located_path)
    {
        if (file_exists($located_path)) {
            return $this;
        }

        throw new RuntimeException('Resource Extension File Does Not Exist for Path: ' . $located_path);
    }

    /**
     * Set Js or CSS for this Extension
     *
     * @param   string $type
     * @param   string $extension_path
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setExtensionAsset($type, $extension_path, array $options)
    {
        $type = ucfirst(strtolower($type));

        try {
            return $this->resource->get($type . ':///' . $extension_path, $options);

        } catch (Exception $e) {

            throw new RuntimeException(
                'Resource Extension Handler: setExtensionAsset failed: ' . $extension_path
            );
        }
    }
}
