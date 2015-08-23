<?php
/**
 * Application Base
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Application;

use CommonApi\Fieldhandler\FieldhandlerInterface;
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
     * Fieldhandler Usage Trait
     *
     * @var     object  CommonApi\Fieldhandler\FieldhandlerUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Fieldhandler\FieldhandlerUsageTrait;

    /**
     * Query Usage Trait
     *
     * @var     object  CommonApi\Query\QueryUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Query\QueryUsageTrait;

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
     * Site ID
     *
     * @var    int
     * @since  1.0
     */
    protected $site_id = null;

    /**
     * Application Base Path
     *
     * @var    string
     * @since  1.0
     */
    protected $application_base_path = null;

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
     * @param QueryInterface        $resource
     * @param FieldhandlerInterface $fieldhandler
     * @param string                $request_path
     * @param array                 $applications
     * @param object                $runtime_data
     *
     * @since  1.0
     */
    public function __construct(
        QueryInterface $resource,
        FieldhandlerInterface $fieldhandler,
        $request_path,
        array $applications = array(),
        $runtime_data
    ) {
        $this->resource     = $resource;
        $this->fieldhandler = $fieldhandler;
        $this->request_path = $request_path;
        $this->applications = $applications;
        $this->runtime_data = $runtime_data;
    }
}
