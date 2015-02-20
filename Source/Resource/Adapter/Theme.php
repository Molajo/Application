<?php
/**
 * Theme Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\AdapterInterface;

/**
 * Theme Resources
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class Theme extends Extension implements AdapterInterface
{
    /**
     * Catalog Type Id
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_id = 7000;

    /**
     * Catalog Type Priority
     *
     * @var    integer
     * @since  1.0.0
     */
    protected $catalog_type_priority = 100;

    /**
     * Default Partial Path
     *
     * @var    string
     * @since  1.0.0
     */
    protected $default_partial_path = 'Source/Themes';

    /**
     * Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $file_name = 'Index.phtml';

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
        $handler_options['catalog_type_id']       = $this->catalog_type_id;
        $handler_options['catalog_type_priority'] = $this->catalog_type_priority;
        $handler_options['default_partial_path']  = $this->default_partial_path;
        $handler_options['file_name']             = $this->file_name;

        parent::__construct(
            $base_path,
            $resource_map,
            $namespace_prefixes,
            $valid_file_extensions,
            $cache_callbacks,
            $handler_options
        );
    }
}
