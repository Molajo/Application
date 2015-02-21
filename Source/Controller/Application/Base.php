<?php
/**
 * Application Base
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Application;

use CommonApi\Model\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;
use stdClass;

/**
 * Application Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Base
{
    /**
     * Catalog Type Application ID
     *
     * @var    int
     * @since  1.0
     */
    protected $catalog_type_application_id = 2000;

    /**
     * Applications
     *
     * @var    array
     * @since  1.0
     */
    protected $applications = array();

    /**
     * Application Model Registry
     *
     * @var    array
     * @since  1.0
     */
    protected $model_registry = array();

    /**
     * Query Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $query;

    /**
     * Fieldhandler Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $fieldhandler;

    /**
     * Path
     *
     * @var    string
     * @since  1.0
     */
    protected $request_path = null;

    /**
     * Application Data
     *
     * @var    stdClass
     * @since  1.0
     */
    protected $data;

    /**
     * Application Name
     *
     * @var    string
     * @since  1.0
     */
    protected $name = null;

    /**
     * Application ID
     *
     * @var    int
     * @since  1.0
     */
    protected $id = null;

    /**
     * Application Base Path
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path = null;

    /**
     * Application Path
     *
     * @var    string
     * @since  1.0
     */
    protected $path = null;

    /**
     * Constructor
     *
     * @param QueryInterface        $query
     * @param FieldhandlerInterface $fieldhandler
     * @param string                $request_path
     * @param array                 $applications
     * @param array                 $model_registry
     *
     * @since  1.0
     */
    public function __construct(
        QueryInterface $query,
        FieldhandlerInterface $fieldhandler,
        $request_path,
        array $applications = array(),
        array $model_registry = array()
    ) {
        $this->query          = $query;
        $this->fieldhandler   = $fieldhandler;
        $this->request_path   = $request_path;
        $this->applications   = $applications;
        $this->model_registry = $model_registry;
    }
}
