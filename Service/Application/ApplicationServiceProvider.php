<?php
/**
 * Application Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Application;

use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\IoC\AbstractServiceProvider;

/**
 * Application Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ApplicationServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_name']      = basename(__DIR__);
        $options['service_namespace'] = 'Molajo\\Controller\\Application';

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the ServiceProviderInterface
     * Retrieve a list of Interface dependencies and return the data ot the controller.
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies($reflection);

        $this->dependencies['Database']     = array();
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
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['applications']     =
            $this->dependencies['Resource']->get('xml:///Molajo//Model//Application//Instances.xml');
        $this->dependencies['model_registry']   =
            $this->dependencies['Resource']->get('xml:///Molajo//Model//Datasource//Application.xml');
        $this->dependencies['request_path']     = $this->dependencies['Request']->path;
        $this->dependencies['request_base_url'] = $this->dependencies['Request']->base_url;

        return $this->dependencies;
    }

    /**
     * Follows the completion of the instantiate service method
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInstantiation()
    {
        $this->service_instance->setApplication();

        $this->service_instance->verifySiteApplication($this->dependencies['Runtimedata']->site->id);

        $configuration = $this->sortObject($this->service_instance->getConfiguration());

        $this->service_instance = $configuration;

        $this->dependencies['Runtimedata']->application = $configuration;

        $this->dependencies['Runtimedata']->site->cache_folder =
            $this->dependencies['Runtimedata']->base_folder
            . $this->dependencies['Runtimedata']->site->base_folder
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_cache_folder;

        $this->dependencies['Runtimedata']->site->logs_folder =
            $this->dependencies['Runtimedata']->base_folder
            . $this->dependencies['Runtimedata']->site->base_folder
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_logs_folder;

        $this->dependencies['Runtimedata']->site->media_folder =
            $this->dependencies['Runtimedata']->base_folder
            . $this->dependencies['Runtimedata']->site->base_folder
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_media_folder;

        $this->dependencies['Runtimedata']->site->temp_folder =
            $this->dependencies['Runtimedata']->base_folder
            . $this->dependencies['Runtimedata']->site->base_folder
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_temp_folder;

        $this->dependencies['Runtimedata']->site->temp_url =
            $this->dependencies['Runtimedata']->site->base_url
            . '/'
            . $configuration->parameters->system_temp_url;

        $base_url  = $this->dependencies['Runtimedata']->request->data->base_url;
        $base_path = $this->dependencies['Runtimedata']->application->base_path;

        $this->dependencies['Runtimedata']->application->base_url = $base_url . '/' . $base_path;

        return $this;
    }

    /**
     * Service Provider Controller requests any Services (other than the current service) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setServices()
    {
        $this->set_services['Runtimedata'] = $this->dependencies['Runtimedata'];

        return $this->set_services;
    }
}
