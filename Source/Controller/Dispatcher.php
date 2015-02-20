<?php
/**
 * Dispatcher - Get Resource
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ResourceInterface;

/**
 * Dispatcher - Get Resource
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Dispatcher implements ResourceInterface
{
    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0
     */
    protected $runtime_data = null;

    /**
     * Resource Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $resource_instance = null;

    /**
     * Page Type
     *
     * @var    string
     * @since  1.0
     */
    protected $page_type = null;

    /**
     * Route
     *
     * @var    object
     * @since  1.0
     */
    protected $route = null;

    /**
     * Page Type Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $page_type_instance = null;

    /**
     * Standard Page Types
     *
     * @var    array
     * @since  1.0
     */
    protected $standard_page_types = array('create', 'delete', 'edit', 'item', 'list', 'new', 'update');

    /**
     * Resource Data
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Constructor
     *
     * @param  object $resource_instance
     * @param  object $route
     * @param  object $runtime_data
     *
     * @since  1.0
     */
    public function __construct(
        $resource_instance,
        $route,
        $runtime_data
    ) {
        $this->resource_instance = $resource_instance;
        $this->route             = $route;
        $this->runtime_data      = $runtime_data;
        $this->page_type         = ucfirst(strtolower($this->route->page_type));
    }

    /**
     * Get Resource Data for Route
     *
     * @return  object
     * @since   1.0.0
     */
    public function getResource()
    {
        $this->createPageTypeInstance();

        $this->getResourceObject();

        return $this->resource;
    }

    /**
     * Create Page Type Class
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function createPageTypeInstance()
    {
        $test_page_type = strtolower($this->page_type);

        if (in_array($test_page_type, $this->standard_page_types)) {
            $class_name = 'Molajo\\Controller\\Resource\\' . ucfirst(strtolower($this->page_type)) . 'PageType';
        } else {
            $class_name = 'Molajo\\Controller\\Resource\\Menuitem';
        }

        $this->page_type_instance = new $class_name($this->resource_instance, $this->route, $this->runtime_data);

        return $this;
    }

    /**
     * Get Resource from the PageType instance
     *
     * @return  $this
     * @since   1.0.0
     */
    public function getResourceObject()
    {
        $this->resource = $this->page_type_instance->getResource();

        return $this;
    }
}
