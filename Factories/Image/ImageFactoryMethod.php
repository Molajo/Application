<?php
/**
 * Image Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Image;

use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethodBase;

/**
 * Image Controller Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ImageFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace']        = 'Molajo\\Controller\\ImageController';
        $options['store_instance_indicator'] = true;
        $options['product_name']             = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Identify Class Dependencies for Constructor Injection
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        $reflection = null;

        $this->dependencies['Runtimedata'] = array();

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
        $media_folder  = $this->dependencies['Runtimedata']->site->media_folder;
        $standard_size = array(
            'thumbnail' => array('width' => 50, 'height' => 50),
            'small'     => array('width' => 75, 'height' => 75),
            'medium'    => array('width' => 150, 'height' => 150),
            'large'     => array('width' => 300, 'height' => 300),
            'xlarge'    => array('width' => 500, 'height' => 500),
            'normal'    => array('width' => null, 'height' => null)
        );
        $standard_type = array('portrait', 'landscape', 'auto', 'crop');
        $default_size  = 'normal';
        $default_type  = 'auto';

        $class                = 'Molajo\\Controller\\ImageController';
        $this->product_result = new $class(
            $media_folder,
            $standard_size,
            $standard_type,
            $default_size,
            $default_type
        );

        return $this;
    }
}
