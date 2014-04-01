<?php
/**
 * Menuitem Resources
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use Exception;
use CommonApi\Resource\AdapterInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Menuitem Resources
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class Menuitem extends AbstractAdapter implements AdapterInterface
{
    /**
     * Rendering Extensions
     *
     * @var    object
     * @since  1.0
     */
    protected $extensions = null;

    /**
     * Extension Object
     *
     * @var    object
     * @since  1.0
     */
    protected $extension = null;

    /**
     * Parameters
     *
     * @var    object
     * @since  1.0
     */
    protected $parameters = null;

    /**
     * Catalog Type ID
     *
     * @var    int
     * @since  1.0
     */
    protected $catalog_type_id = 11000;

    /**
     * Catalog Type Priority
     *
     * @var    int
     * @since  1.0
     */
    protected $catalog_type_priority = 200;

    /**
     * Resource Instance to retrieve CSS and JS files
     *
     * @var    object
     * @since  1.0
     */
    protected $resource;

    /**
     * Constructor
     *
     * @param  string $base_path
     * @param  array  $resource_map
     * @param  array  $namespace_prefixes
     * @param  array  $valid_file_extensions
     * @param  object $extensions
     * @param  object $resource
     *
     * @since  1.0
     */
    public function __construct(
        $base_path,
        array $resource_map = array(),
        array $namespace_prefixes = array(),
        array $valid_file_extensions = array(),
        $extensions,
        $resource
    ) {
        parent::__construct(
            $base_path,
            $resource_map,
            $namespace_prefixes,
            $valid_file_extensions,
            $resource
        );

        $this->extensions = $extensions;
        $this->resource   = $resource;
    }

    /**
     * Set a namespace prefix by mapping to the filesystem path
     *
     * @param   string  $namespace_prefix
     * @param   string  $namespace_base_directory
     * @param   boolean $prepend
     *
     * @return  $this
     * @since   1.0
     */
    public function setNamespace($namespace_prefix, $namespace_base_directory, $prepend = false)
    {
        return parent::setNamespace($namespace_prefix, $namespace_base_directory, $prepend);
    }

    /**
     * Locates folder/file associated with Namespace for Resource
     *
     * @param   string $resource_namespace
     *
     * @return  void|mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($resource_namespace, $multiple = false)
    {
        $menuitem = substr($resource_namespace, strrpos($resource_namespace, '/') + 1, 9999);

        $test = $menuitem;
        if (is_numeric($test) && (int)$test == $menuitem) {
        } else {
            $test     = strtolower($test);
            $menuitem = $this->extensions->extensions[$this->catalog_type_id]->names[$test];
        }

        $temp = substr($resource_namespace, 0, strrpos($resource_namespace, '/') - 1);

        if (isset($this->extensions->extensions[$this->catalog_type_id]->ids[$menuitem])) {
            $this->extension = $this->extensions->extensions[$this->catalog_type_id]->extensions[$menuitem];
        }

        $this->extension->resource_namespace = $temp . '//' . ucfirst(strtolower($this->extension->alias));

        return parent::get($this->extension->resource_namespace);
    }

    /**
     * Search compiled namespace map for resource namespace
     *
     * @param   string $resource_namespace
     *
     * @return  mixed|bool|string
     * @since   1.0
     */
    protected function searchResourceMap($resource_namespace, $multiple = false)
    {
        if (isset($this->resource_map[strtolower($resource_namespace)])) {
        } else {

            /** Default location */
            $path = $this->base_path . '/Source/Menuitem/'
                . ucfirst(strtolower($this->extension->alias));

            $this->extension->include_path = $path . '/' . 'Configuration.xml';
            $this->extension->path         = $path;

            return $this->extension->include_path;
        }

        $paths = $this->resource_map[strtolower($resource_namespace)];

        if (is_array($paths)) {
        } else {
            $paths = array($paths);
        }

        foreach ($paths as $path) {
            $this->extension->include_path = $path . '/' . 'Configuration.xml';
            $this->extension->path         = $path;

            return $this->extension->include_path;
        }

        return false;
    }

    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $scheme
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function handlePath($scheme, $located_path, array $options = array())
    {
        if (file_exists($located_path)) {
        } else {
            throw new RuntimeException ('Resource: Menuitem not found.');
        }

        try {
            $options                 = array();
            $options['located_path'] = $this->extension->path . '/Css';
            $options['priority']     = $this->catalog_type_priority;
            $this->resource->get('Css:///' . $this->extension->resource_namespace, $options);
        } catch (Exception $e) {

            throw new RuntimeException
            ('Resource Menuitem Handler: Get Menuitem CSS failed: ' . $this->extension->resource_namespace);
        }

        try {
            $options                 = array();
            $options['located_path'] = $this->extension->path . '/Js';
            $options['priority']     = $this->catalog_type_priority;
            $this->resource->get('Js:///' . $this->extension->resource_namespace, $options);
        } catch (Exception $e) {

            throw new RuntimeException
            ('Resource Menuitem Handler: Get Menuitem Js failed: ' . $this->extension->resource_namespace);
        }

        return $this->extension;
    }

    /**
     * Retrieve a collection of a specific handler
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getCollection($scheme, array $options = array())
    {
        return $this;
    }
}