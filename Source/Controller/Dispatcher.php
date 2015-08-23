<?php
/**
 * Dispatcher - Get Resource
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Application\ResourceInterface;
use CommonApi\Fieldhandler\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;

/**
 * Dispatcher - Get Resource
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
final class Dispatcher implements ResourceInterface
{
    /**
     * Resource Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Fieldhandler\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0
     */
    protected $runtime_data = null;

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
     * Resource Output
     *
     * @var    object
     * @since  1.0
     */
    protected $resource_output = null;

    /**
     * Constructor
     *
     * @param  QueryInterface        $resource
     * @param  FieldhandlerInterface $fieldhandler
     * @param  object                $runtime_data
     * @param  object                $route
     *
     * @since  1.0
     */
    public function __construct(
        QueryInterface $resource,
        FieldhandlerInterface $fieldhandler,
        $runtime_data,
        $route
    ) {
        $this->resource     = $resource;
        $this->fieldhandler = $fieldhandler;
        $this->runtime_data = $runtime_data;
        $this->route        = $route;
        $this->page_type    = ucfirst(strtolower($this->route->page_type));
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

        return $this->resource_output;
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

        $this->page_type_instance = new $class_name(
            $this->resource,
            $this->fieldhandler,
            $this->runtime_data,
            $this->route
        );

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
        $this->resource_output = $this->page_type_instance->getResource();

        return $this;
    }
}
