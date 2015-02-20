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
        $handler_options = $this->setHandlerOptions(
            $handler_options,
            11000,
            200,
            'Source/Menuitem',
            'Configuration.xml'
        );

        parent::__construct(
            $base_path,
            $resource_map,
            $namespace_prefixes,
            $valid_file_extensions,
            $cache_callbacks,
            $handler_options
        );
    }

    /**
     * Extension Trait
     *
     * @var     object  Molajo\Resource\Adapter\ExtensionTrait
     * @since   1.0.0
     */
    use \Molajo\Resource\Adapter\ExtensionTrait;
}
