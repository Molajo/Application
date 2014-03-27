<?php
/**
 * Plugindata Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Plugindata;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethodBase;
use stdClass;

/**
 * Plugindata Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class PlugindataFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['product_namespace']        = 'Plugindata';

        parent::__construct($options);
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateClass()
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

        $this->product_result = $plugin_data;

        return $this;
    }
}
