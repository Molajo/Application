<?php
/**
 * Menuitem Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
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
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class Menuitem extends Extension implements AdapterInterface
{
    /**
     * Catalog Type Id
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_id = 11000;

    /**
     * Catalog Type Priority
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_priority = 200;

    /**
     * Default Partial Path
     *
     * @var    string
     * @since  1.0.0
     */
    protected $default_partial_path = 'Source/Menuitem';

    /**
     * Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $file_name = 'Configuration.xml';

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
        return $this->getExtension($this->catalog_type_id, $resource_namespace);
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
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $scheme
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function handlePath($scheme, $located_path, array $options = array())
    {
        if (file_exists($located_path)) {
        } else {
            throw new RuntimeException('Resource: Menuitem not found.');
        }

        try {
            $options                 = array();
            $options['located_path'] = $this->extension_path . '/Css';
            $options['priority']     = $this->catalog_type_priority;
            $this->resource->get('Css:///' . $this->extension->resource_namespace, $options);

        } catch (Exception $e) {

            throw new RuntimeException(
                'Resource Menuitem Handler: Get Menuitem CSS failed: ' . $this->extension->resource_namespace
            );
        }

        try {
            $options                 = array();
            $options['located_path'] = $this->extension_path . '/Js';
            $options['priority']     = $this->catalog_type_priority;
            $this->resource->get('Js:///' . $this->extension->resource_namespace, $options);

        } catch (Exception $e) {

            throw new RuntimeException(
                'Resource Menuitem Handler: Get Menuitem Js failed: ' . $this->extension->resource_namespace
            );
        }

        return $this->extension;
    }

    /**
     * Retrieve a collection of a specific handler
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  string
     * @since   1.0.0
     */
    public function getCollection($scheme, array $options = array())
    {
        return $this;
    }
}
