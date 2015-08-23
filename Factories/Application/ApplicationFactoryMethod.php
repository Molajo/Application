<?php
/**
 * Application Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Application;

use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;
use stdClass;

/**
 * Application Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ApplicationFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['store_instance_indicator'] = false;
        $options['product_namespace']        = 'Molajo\\Controller\\Application';

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
        parent::setDependencies($reflection);

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
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['applications'] = $this->getApplicationInstances();
        $this->dependencies['request_path'] = $this->dependencies['Request']->path;

        return $this->dependencies;
    }

    /**
     * Factory Method Controller triggers the Factory Method to create the Class for the Service
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $this->product_result = new $this->product_namespace(
            $this->dependencies['Resource'],
            $this->dependencies['Fieldhandler'],
            $this->dependencies['request_path'],
            $this->dependencies['applications'],
            $this->dependencies['Runtimedata']
        );

        return $this;
    }

    /**
     * Follows the completion of the instantiate method
     *
     * @return  $this
     * @since   1.0.0
     */
    public function onAfterInstantiation()
    {
        $this->product_result->setApplication();

        $this->product_result->verifySiteApplication($this->dependencies['Runtimedata']->site->id);

        $configuration = $this->sortObject($this->product_result->getConfiguration());

        $this->product_result = $configuration;

        $this->setRuntimedataApplicationConfiguration($configuration);

        return $this;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0.0
     */
    public function setContainerEntries()
    {
        $this->set_container_entries['Runtimedata'] = $this->dependencies['Runtimedata'];

        return $this->set_container_entries;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0.0
     */
    public function getApplicationInstances()
    {
        $xml          = $this->dependencies['Resource']->get('xml://Molajo//Model//Application//Instances.xml');
        $applications = array();

        foreach ($xml as $app) {

            $row       = new stdClass();
            $row->name = trim(strtolower((string)$app->name));
            $row->id   = (string)$app->id;

            if ($row->name === 'site') {
                $row->base_path = '';
                $row->default   = 1;
            } else {
                $row->base_path = $row->name;
                $row->default   = 0;
            }

            $applications[$row->name] = $row;
        }

        return $applications;
    }

    /**
     * Save Application Configuration into the Runtime Data Object
     *
     * @param   object $configuration
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setRuntimedataApplicationConfiguration($configuration)
    {
        $this->dependencies['Runtimedata']->application = $configuration;

        $this->dependencies['Runtimedata']->site->cache_folder
            = $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_cache_folder;

        $this->dependencies['Runtimedata']->site->logs_folder
            = $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_logs_folder;

        $this->dependencies['Runtimedata']->site->media_folder
            = $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_media_folder;

        $this->dependencies['Runtimedata']->site->temp_folder
            = $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_temp_folder;

        $base_url = $this->dependencies['Runtimedata']->request->data->base_url;

        $base_path = $this->dependencies['Runtimedata']->application->application_base_path;

        $this->dependencies['Runtimedata']->application->base_url = $base_url . $base_path . '/';

        $this->dependencies['Runtimedata']->application->model_registry = $this->dependencies['model_registry'];

        return $this;
    }
}
