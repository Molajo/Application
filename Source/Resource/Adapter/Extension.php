<?php
/**
 * Extension Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;
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
abstract class Extension extends NamespaceHandler implements ResourceInterface
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
     * Class
     *
     * @var    string
     * @since  1.0.0
     */
    protected $class = null;

    /**
     * Resource Namespace
     *
     * @var    string
     * @since  1.0.0
     */
    protected $resource_namespace = null;

    /**
     * Class Properties
     *
     * @var    array
     * @since  1.0.0
     */
    protected $class_properties
        = array(
            'Menuitem' => array(
                'catalog_type_id'       => 11000,
                'catalog_type_priority' => 200,
                'default_partial_path'  => 'Source/Menuitem',
                'file_name'             => 'Configuration.phtml'
            ),
            'Page'     => array(
                'catalog_type_id'       => 8000,
                'catalog_type_priority' => 200,
                'default_partial_path'  => 'Source/Views/Pages',
                'file_name'             => 'Index.phtml'
            ),
            'Plugin'     => array(
                'catalog_type_id'       => 5000,
                'catalog_type_priority' => 600,
                'default_partial_path'  => 'Source/Plugins',
                'file_name'             => ''
            ),
            'Template' => array(
                'catalog_type_id'       => 9000,
                'catalog_type_priority' => 200,
                'default_partial_path'  => 'Source/Views/Templates',
                'file_name'             => ''
            ),
            'Theme'    => array(
                'catalog_type_id'       => 7000,
                'catalog_type_priority' => 200,
                'default_partial_path'  => 'Source/Themes',
                'file_name'             => 'Index.phtml'
            ),
            'Wrap'     => array(
                'catalog_type_id'       => 10000,
                'catalog_type_priority' => 600,
                'default_partial_path'  => 'Source/Views/Wraps',
                'file_name'             => ''
            )
        );

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

        $this->setClassProperties($handler_options);
    }

    /**
     * Set Class properties using Handler Options array
     *
     * @param   array $handler_options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setClassProperties(array $handler_options = array())
    {
        if (count($handler_options) === 0) {
            return $this;
        }

        $this->extensions = $handler_options['extensions'];

        $this->class = ucfirst(strtolower($handler_options['scheme_name']));

        $this->catalog_type_id       = $this->class_properties[$this->class]['catalog_type_id'];
        $this->catalog_type_priority = $this->class_properties[$this->class]['catalog_type_priority'];
        $this->default_partial_path  = $this->class_properties[$this->class]['default_partial_path'];
        $this->file_name             = $this->class_properties[$this->class]['file_name'];

        return $this;
    }

    /**
     * Locates resource for extension
     *
     * @param   string $resource_namespace
     * @param   array  $options
     *
     * @return  string
     * @since   1.0.0
     */
    public function get($resource_namespace, array $options = array())
    {
        $node  = $resource_namespace;
        $alias = $this->getExtensionAlias($node);

        if ($alias === $node) {
            $id = $this->getExtensionId($alias);
        } else {
            $id    = $node;
        }

        $catalog_type_id = $this->catalog_type_id;
        $this->extension = $this->extensions->extensions[$catalog_type_id]->extensions[$id];

        $this->resource_namespace = $this->extensions->extensions[$catalog_type_id]->namespaces[$id];

        return parent::get($this->resource_namespace, $options);
    }

    /**
     * Get Alias for Extension
     *
     * @param   string $extension
     *
     * @return  string
     * @since   1.0.0
     */
    protected function getExtensionAlias($extension)
    {
        $test            = strtolower($extension);
        $catalog_type_id = $this->catalog_type_id;

        if (isset($this->extensions->extensions[$catalog_type_id]->ids[$test])) {
            $alias = $this->extensions->extensions[$catalog_type_id]->ids[$test];
        } else {
            $alias = $extension;
        }

        return $alias;
    }

    /**
     * Get Extension ID using the alias as a key
     *
     * @param   string $alias
     *
     * @return  string
     * @since   1.0.0
     */
    protected function getExtensionId($alias)
    {
        $catalog_type_id = $this->catalog_type_id;
        $alias           = strtolower($alias);

        if (isset($this->extensions->extensions[$catalog_type_id]->names[$alias])) {
        } else {
            return $alias;
        }

        $id_array = $this->extensions->extensions[$catalog_type_id]->names[$alias];

        if (count($id_array) === 1) {
            return (int) $id_array[0];
        }

echo 'Finish code for Multiple IDs for same Alias: ' . $alias;
        echo '<pre>';
        var_dump($id_array);
        echo '</pre>';
        die;

        //todo: first use current theme, then system.

        return $id_array[0];
    }

    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  object
     * @since   1.0.0
     */
    public function handlePath($located_path, array $options = array())
    {
        $this->checkFileExists($located_path);
/**
        $asset_options             = array();
        $asset_options['priority'] = $this->catalog_type_priority;
        $this->setExtensionAsset('Css', $this->resource_namespace . '\Css', $asset_options);

        $this->setExtensionAsset('Js', $this->resource_namespace . '\Js', $asset_options);

        $options['defer'] = 'defer';
        $this->setExtensionAsset('Js', $this->resource_namespace . '\Jsdefer', $asset_options);
*/
        $this->extension->path = $located_path;

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
     * @param   string $resource_namespace
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setExtensionAsset($type, $resource_namespace, array $options)
    {
        $type                  = ucfirst(strtolower($type));
        $get_resource_callback = $this->get_resource_callback;

        try {
            return $get_resource_callback($type . '://' . $resource_namespace, $options);

        } catch (Exception $e) {

            throw new RuntimeException(
                'Resource Extension Handler: setExtensionAsset failed: ' . $resource_namespace
            );
        }
    }
}
