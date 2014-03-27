<?php
/**
 * Extensions Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Extensions;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethodBase;

/**
 * Extensions Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ExtensionsFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Controller
     *
     * @var    object  CommonApi\Controller\ReadInterface
     * @since  1.0
     */
    protected $controller = null;

    /**
     * Constructor
     *
     * @param  $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['product_namespace']        = 'Molajo\\Resource\\ExtensionMap';

        parent::__construct($options);
    }

    /**
     * Define dependencies or use dependencies automatically defined by base class using Reflection
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies($reflection);

        $options                           = array();
        $this->dependencies['Resource']    = $options;
        $this->dependencies['Runtimedata'] = $options;
        $this->dependencies['Cache']       = $options;

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

        $this->dependencies['extensions_filename']
            = $this->options['base_path'] . '/Bootstrap/Files/Output/Extensions.json';

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateClass()
    {
        $cache_results = $this->dependencies['Cache']->get('Extensions');

        if ($cache_results === false || $cache_results->is_hit === false) {

            try {
                $this->product_result = new $this->product_namespace(
                    $this->dependencies['Resource'],
                    $this->dependencies['Runtimedata'],
                    $this->dependencies['extensions_filename']
                );
            } catch (Exception $e) {
                throw new RuntimeException
                ('Render: Could not instantiate Handler: ' . $this->product_namespace);
            }

            $extensions           = $this->product_result->createMap();
            $this->product_result = $extensions;
            $this->dependencies['Cache']->set('Extensions', $extensions);

        } else {
            $this->product_result = $cache_results->value;
        }

        return $this;
    }
}
