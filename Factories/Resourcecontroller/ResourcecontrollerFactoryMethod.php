<?php
/**
 * Resource Ccontroller Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Resourcecontroller;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Resource Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ResourcecontrollerFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param   $options
     *
     * @since   1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_namespace']        = 'Molajo\\Controller\\ResourceController';
        $options['store_instance_indicator'] = true;
        $options['product_name']             = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Identify Class Dependencies for Constructor Injection
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies($reflection);

        $options                           = array();
        $this->dependencies['Resource']    = $options;
        $this->dependencies['Runtimedata'] = $options;

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $default_theme_id = $this->dependencies['Runtimedata']->application->parameters->application_default_theme_id;
        $page_type        = $this->dependencies['Runtimedata']->route->page_type;
        $model_type       = $this->dependencies['Runtimedata']->route->b_model_type;
        $model_name       = $this->dependencies['Runtimedata']->route->b_model_name;
        $sef_request      = $this->dependencies['Runtimedata']->route->sef_request;
        $source_id        = (int)$this->dependencies['Runtimedata']->route->source_id;

        try {
            $class = $this->product_namespace;

            $this->product_result = new $class(
                $this->dependencies['Resource'],
                $default_theme_id,
                $page_type,
                $model_type,
                $model_name,
                $sef_request,
                $source_id
            );
        } catch (Exception $e) {

            throw new RuntimeException(
                'IoC instantiateClass Failed: '
                . $this->product_namespace . '  ' . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * Follows the completion of the instantiate method
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInstantiation()
    {
        $this->dependencies['Runtimedata']->resource = $this->product_result->getResource();
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setContainerEntries()
    {
        $this->set_container_entries['Runtimedata'] = $this->dependencies['Runtimedata'];

        return $this->set_container_entries;
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleFactories()
    {
        $options                                = array();
        $this->schedule_factory_methods['Date'] = $options;

        return $this->schedule_factory_methods;
    }
}
