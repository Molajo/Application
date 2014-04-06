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
use Molajo\IoC\FactoryMethodBase;

/**
 * Resource Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
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
    public function setDependencies(array $reflection = null)
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

            throw new RuntimeException
            (
                'IoC instantiateClass Failed: ' . $this->product_namespace . '  ' . $e->getMessage()
            );
        }

        return $this;
    }
}
