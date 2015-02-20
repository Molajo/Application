<?php
/**
 * Template View Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\AdapterInterface;

/**
 * Template View Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class Template extends Extension implements AdapterInterface
{
    /**
     * Catalog Type Id
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_id = 9000;

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
    protected $default_partial_path = 'Source/Views/Templates';

    /**
     * Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $file_name = '';

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
     * Retrieve a collection of a specific handler
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  Template
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getCollection($scheme, array $options = array())
    {
        return $this;
    }
}
