<?php
/**
 * Runtimedata Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Runtimedata;

use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;
use stdClass;

/**
 * Runtimedata Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class RuntimedataFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace']        = 'Runtimedata';

        parent::__construct($options);
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $folders = readJsonFile($this->base_path . '/Bootstrap/Files/Output/ExtensionFolders.json');

        $runtime_data                             = new stdClass();
        $runtime_data->error_code                 = 0;
        $runtime_data->redirect_to_id             = 0;
        $runtime_data->base_path                  = $this->base_path;
        $runtime_data->extension_folders          = $folders;
        $runtime_data->request                    = new stdClass();
        $runtime_data->request->data              = new stdClass();
        $runtime_data->request->client            = new stdClass();
        $runtime_data->request->server            = new stdClass();
        $runtime_data->site                       = new stdClass();
        $runtime_data->application                = new stdClass();
        $runtime_data->route                      = new stdClass();
        $runtime_data->user                       = new stdClass();
        $runtime_data->reference_data             = new stdClass();
        $runtime_data->reference_data->extensions = new stdClass();
        $runtime_data->resource                   = new stdClass();
        $runtime_data->resource->data             = new stdClass();
        $runtime_data->resource->parameters       = new stdClass();
        $runtime_data->resource->model_registry   = new stdClass();

        $this->product_result = $runtime_data;

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
        $this->set_container_entries['rendered_page'] = '';

        return $this->set_container_entries;
    }

    /**
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0.0
     */
    public function scheduleFactories()
    {
        $options                                      = array();
        $this->schedule_factory_methods['Plugindata'] = $options;

        return $this->schedule_factory_methods;
    }
}
