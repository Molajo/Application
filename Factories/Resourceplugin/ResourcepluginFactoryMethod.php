<?php
/**
 * Resource Wrap Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Resourceplugin;

use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Resource Wrap Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ResourcepluginFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param  $options
     *
     * @since  1.0.0
     */
    public function __construct(array $options = array())
    {
        $options['product_namespace']        = 'Molajo\\Resource\\Adapter\\Plugin';
        $options['store_instance_indicator'] = false;
        $options['product_name']             = null;

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies(array());

        $this->dependencies['Runtimedata'] = array();

        return $this->dependencies;
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  object
     * @since   1.0.0
     */
    public function scheduleFactories()
    {
        $options                          = array();
        $options['scheme_name']           = 'Plugin';
        $options['product_namespace']     = $this->product_namespace;
        $options['valid_file_extensions'] = array();
        $options['handler_options']       = $this->setHandlerOptions();

        $this->schedule_factory_methods['Resourceadapter'] = $options;

        return $this->schedule_factory_methods;
    }

    /**
     * Set Handler Options for Factory
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function setHandlerOptions()
    {
        $handler_options = array();

        $handler_options['extensions']  = $this->dependencies['Runtimedata']->reference_data->extensions;
        $handler_options['scheme_name'] = 'plugin';

        return $handler_options;
    }
}
