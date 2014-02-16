<?php
/**
 * Resourcequery Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Resourcequery;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\ServiceProviderInterface;
use Molajo\IoC\AbstractServiceProvider;

/**
 * Resourcequery Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ResourcequeryServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_namespace'] = 'Molajo\\Resource\\Handler\\QueryHandler';
        $options['service_name']      = basename(__DIR__);

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

        $this->dependencies['Resource']      = array();
        $this->dependencies['Runtimedata']   = array();
        $this->dependencies['Eventcallback'] = array();

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

        $this->dependencies['base_path']          = BASE_FOLDER;
        $this->dependencies['resource_map']       = $this->readFile(
            BASE_FOLDER . '/vendor/molajo/resource/Source/Files/Output/ResourceMap.json'
        );
        $this->options['Scheme']                  = $this->createScheme();
        $this->dependencies['namespace_prefixes'] = array();
        $this->dependencies['valid_file_extensions']
                                                  = $this->options['Scheme']->getScheme(
            'Query'
        )->include_file_extensions;

        $this->dependencies['query']        = $this->dependencies['Database']->getQueryObject();
        $this->dependencies['null_date']    = $this->dependencies['Database']->getNullDate();
        $this->dependencies['current_date'] = $this->dependencies['Database']->getDate();
        $this->dependencies['schedule_event'] = $this->dependencies['Eventcallback'];

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
        $this->dependencies['Resource']->setHandlerInstance('QueryHandler', $this->service_instance);

        return $this;
    }

    /**
     * Create Scheme Instance
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function createScheme()
    {
        $class = 'Molajo\\Resource\\Scheme';

        $input = BASE_FOLDER . '/vendor/molajo/resource/Source/Files/Input/SchemeArray.json';

        try {
            $scheme = new $class ($input);
        } catch (Exception $e) {
            throw new RuntimeException ('Resource Scheme ' . $class
            . ' Exception during Instantiation: ' . $e->getMessage());
        }

        return $scheme;
    }
}
