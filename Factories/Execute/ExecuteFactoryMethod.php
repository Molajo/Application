<?php
/**
 * Execute Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Execute;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryBatchInterface;
use CommonApi\IoC\FactoryInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;
use stdClass;

/**
 * Execute Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
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

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies($reflection);

        $this->dependencies['Runtimedata'] = array();
        $this->dependencies['Resource']    = array();

        return $this->dependencies;
    }

    /**
     * Set Extension Data for Resource
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInstantiation()
    {
        $this->setResourceExtensions();

        return $this;
    }

    /**
     * Save View Data for Resource
     *
     * @return  $this
     * @since   1.0
     */
    protected function setResourceExtensions()
    {
        $page_type = strtolower($this->dependencies['Runtimedata']->route->page_type);

        $theme_id         = $this->dependencies['Runtimedata']->resource->parameters->theme_id;
        $page_view_id     = $this->dependencies['Runtimedata']->resource->parameters->page_view_id;
        $template_view_id = $this->dependencies['Runtimedata']->resource->parameters->template_view_id;
        $wrap_view_id     = $this->dependencies['Runtimedata']->resource->parameters->wrap_view_id;

        /**
         * echo 'In Execute';
         * echo ' Theme: ' . $theme_id . '<br>';
         * echo ' Page: ' . $page_view_id . '<br>';
         * echo ' Template: ' . $template_view_id . '<br>';
         * echo ' Wrap: ' . $wrap_view_id . '<br>';
         */
        $this->dependencies['Runtimedata']->resource->extensions = new stdClass();

        $scheme = 'theme:///';
        $ns     = 'molajo//themes//' . (int) $theme_id;
        $this->dependencies['Runtimedata']->resource->extensions->theme
                = $this->dependencies['Resource']->get($scheme . $ns);

        $scheme = 'page:///';
        $ns     = 'molajo//views//pages//' . (int) $page_view_id;
        $this->dependencies['Runtimedata']->resource->extensions->page
                = $this->dependencies['Resource']->get($scheme . $ns);

        $scheme = 'template:///';
        $ns     = 'molajo//views//templates//' . (int) $template_view_id;
        $this->dependencies['Runtimedata']->resource->extensions->template
                = $this->dependencies['Resource']->get($scheme . $ns);

        $scheme = 'wrap:///';
        $ns     = 'molajo//views//wraps//' . (int) $wrap_view_id;
        $this->dependencies['Runtimedata']->resource->extensions->wrap
                = $this->dependencies['Resource']->get($scheme . $ns);

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
     * Request for array of Factory Methods to be Scheduled
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleFactories()
    {
        $options              = array();
        $options['base_path'] = $this->base_path;

        if ($this->dependencies['Runtimedata']->route->method === 'GET') {
            $this->schedule_factory_methods['Render'] = $options;
        }

        return $this->schedule_factory_methods;
    }
}
