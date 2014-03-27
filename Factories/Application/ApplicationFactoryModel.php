<?php
/**
 * Application Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Application;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethodBase;
use stdClass;

/**
 * Application Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
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
        $options['product_name']      = basename(__DIR__);
        $options['product_namespace'] = 'Molajo\\Controller\\Application';

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
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
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        $this->dependencies['applications']   = $this->getApplicationInstances();
        $this->dependencies['model_registry'] =
            $this->dependencies['Resource']->get('xml:///Molajo//Model//Datasource//Application.xml');

        $this->dependencies['request_path']     = $this->dependencies['Request']->path;
        $this->dependencies['request_base_url'] = $this->dependencies['Request']->base_url;

        return $this->dependencies;
    }

    /**
     * Follows the completion of the instantiate method
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInstantiation()
    {
        $this->product_result->setApplication();

        $this->product_result->verifySiteApplication($this->dependencies['Runtimedata']->site->id);

        $configuration = $this->sortObject($this->product_result->getConfiguration());

        $this->product_result = $configuration;

        $this->dependencies['Runtimedata']->application = $configuration;

        $this->dependencies['Runtimedata']->site->cache_folder =
            $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_cache_folder;

        $this->dependencies['Runtimedata']->site->logs_folder =
            $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_logs_folder;

        $this->dependencies['Runtimedata']->site->media_folder =
            $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_media_folder;

        $this->dependencies['Runtimedata']->site->temp_folder =
            $this->dependencies['Runtimedata']->site->site_base_path
            . '/'
            . $this->dependencies['Runtimedata']->application->parameters->system_temp_folder;

        $base_url  = $this->dependencies['Runtimedata']->request->data->base_url;
        $base_path = $this->dependencies['Runtimedata']->application->base_path;

        $this->dependencies['Runtimedata']->application->base_url = $base_url . '/' . $base_path;

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
        $this->set_container_entries['Runtimedata'] = $this->dependencies['Runtimedata'];

        return $this->set_container_entries;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function getApplicationInstances()
    {
        $xml          = $this->dependencies['Resource']->get('xml:///Molajo//Model//Application//Instances.xml');
        $applications = array();

        foreach ($xml as $app) {
            $row            = new stdClass();
            $row->name      = trim(strtolower((string)$app->name));
            $row->id        = (string)$app->id;
            $row->base_path = '/' . $app->name;

            $applications[$row->name] = $row;
        }

        return $applications;
    }
}
