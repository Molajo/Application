<?php
/**
 * Execute Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Execute;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethodBase;
use stdClass;

/**
 * Execute Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ExecuteFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_name']      = basename(__DIR__);
        $options['product_namespace'] = null;
echo 'ini ExecuteFactoryMethod';
        die;
        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies($reflection);
        $this->dependencies['Database']     = array();
        $this->dependencies['Query']        = array();
        $this->dependencies['Resource']     = array();
        $this->dependencies['Request']      = array();
        $this->dependencies['Fieldhandler'] = array();
        $this->dependencies['Runtimedata']  = array();

        return $this->dependencies;
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['applications']   = $this->getExecuteInstances();
        $this->dependencies['model_registry'] =
            $this->dependencies['Resource']->get('xml:///Molajo//Model//Datasource//Execute.xml');

        $this->dependencies['request_path']     = $this->dependencies['Request']->path;
echo '<pre>';
        var_dump($this->dependencies['Runtimedata']);
        die;
        return $this->dependencies;
    }


    /**
     * Execute Render or Action
     *
     * @return  $this
     * @since   1.0
     */
    protected function execute()
    {
        if ($this->scheduleFactoryMethod('Runtimedata')->route->method == 'GET') {
            $render_proxy = $this->scheduleFactoryMethod('Render');
            $include_file = $this->scheduleFactoryMethod('Runtimedata')->resource->extensions->theme->extension->path;
            $render_proxy->renderOutput($include_file);
        }

        // create

        // update

        // delete

        // redirect

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


        return $this;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setContainerEntries()
    {
        $this->set_container_entries['Runtimedata']           = $this->dependencies['Runtimedata'];

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
        $options = array();
        $this->schedule_factory_methods['Date'] = $options;

        return $this->schedule_factory_methods;
    }
}
