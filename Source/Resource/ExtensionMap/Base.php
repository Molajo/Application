<?php
/**
 * Base Extension Map Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\ExtensionMap;

use CommonApi\Fieldhandler\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;

/**
 * Queries for Extension Map Class
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
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
     * Extensions Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $extensions_filename;

    /**
     * Extension Ids
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_ids = array();

    /**
     * Extension Names
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_names = array();

    /**
     * Extension Namespaces
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_namespaces = array();

    /**
     * Extensions
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_extensions = array();

    /**
     * Menus
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_menus = array();

    /**
     * Page Types
     *
     * @var    array
     * @since  1.0.0
     */
    protected $temp_page_types = array();

    /**
     * Constructor
     *
     * @param  QueryInterface        $resource
     * @param  FieldhandlerInterface $fieldhandler
     * @param  array                 $runtime_data
     * @param  string                $extensions_filename
     *
     * @since  1.0
     */
    public function __construct(
        QueryInterface $resource,
        FieldhandlerInterface $fieldhandler,
        array $runtime_data,
        $extensions_filename = null
    ) {
        $this->resource            = $resource;
        $this->fieldhandler        = $fieldhandler;
        $this->runtime_data        = $runtime_data;
        $this->extensions_filename = $extensions_filename;
    }

    /**
     * Set Catalog Types Query String
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setCatalogTypesQueryString()
    {
        return (int)$this->runtime_data->reference_data->catalog_type_plugin_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_theme_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_page_view_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_template_view_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_wrap_view_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_menuitem_id . ', '
        . (int)$this->runtime_data->reference_data->catalog_type_resource_id;
    }
}
