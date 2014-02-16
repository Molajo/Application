<?php
/**
 * Plugindata Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Plugindata;

use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\IoC\AbstractServiceProvider;
use stdClass;

/**
 * Plugindata Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class PlugindataServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
{
    /**
     * Constructor
     *
     * @param  array $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['service_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['service_namespace']        = 'Plugindata';

        parent::__construct($options);
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateService()
    {
        $plugin_data                           = new stdClass();
        $plugin_data->page                     = new stdClass();
        $plugin_data->page->urls               = array();
        $plugin_data->datalists                = new stdClass();
        $plugin_data->resource                 = new stdClass();
        $plugin_data->resource->data           = new stdClass();
        $plugin_data->resource->parameters     = new stdClass();
        $plugin_data->resource->model_registry = new stdClass();
        $plugin_data->render                   = new stdClass();

        $this->service_instance = $plugin_data;

        return $this;
    }
}
