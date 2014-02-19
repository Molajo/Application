<?php
/**
 * Runtimedata Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Services\Runtimedata;

use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\IoC\AbstractServiceProvider;
use stdClass;

/**
 * Runtimedata Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class RuntimedataServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_namespace']        = 'Runtimedata';

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
        $runtime_data                  = new stdClass();
        $runtime_data->error_code      = 0;
        $runtime_data->redirect_to_id  = 0;
        $runtime_data->base_folder     = BASE_FOLDER;
        $runtime_data->request         = new stdClass();
        $runtime_data->request->data   = new stdClass();
        $runtime_data->request->client = new stdClass();
        $runtime_data->request->server = new stdClass();
        $runtime_data->site            = new stdClass();
        $runtime_data->application     = new stdClass();
        $runtime_data->route           = new stdClass();
        $runtime_data->user            = new stdClass();
        $runtime_data->reference_data  = new stdClass();

        $this->service_instance = $runtime_data;

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
        $this->set_services['rendered_page'] = '';

        return $this->set_services;
    }
}
