<?php
/**
 * Extension Trait
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

/**
 * Extension Trait
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
trait ExtensionTrait
{
    /**
     * Set Extension Values for Handler Options Array
     *
     * @param  string $file_name
     * @param  array  $handler_options
     *
     * @since  1.0.0
     */
    protected function setHandlerOptions(
        $catalog_type_id,
        $catalog_type_priority,
        $default_partial_path,
        $file_name,
        array $handler_options = array()
    ) {
        $handler_options['catalog_type_id']       = $catalog_type_id;
        $handler_options['catalog_type_priority'] = $catalog_type_priority;
        $handler_options['default_partial_path']  = $default_partial_path;
        $handler_options['file_name']             = $file_name;

        return $handler_options;
    }
}
