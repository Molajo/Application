<?php
/**
 * Factory Handler Trait for Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\FrontController;

use CommonApi\Exception\RuntimeException;
use Exception;

/**
 * Factory Handler Trait for Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
trait FactoryHandlerTrait
{
    /**
     * Factory Method Requests
     *
     * @var    array
     * @since  1.0
     */
    protected $requests;

    /**
     * Factory Method Scheduling
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $schedule;

    /**
     * Store Product in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setContainerEntry($product_name, $value)
    {
        $options          = array();
        $options['set']   = true;
        $options['value'] = $value;

        $this->scheduleFactoryMethod($product_name, 'Container', $options);

        return $this;
    }

    /**
     * Schedule Factory recursively resolving dependencies
     *
     * @param   string $product_name
     * @param   string $debug_type
     * @param   array  $options
     *
     * @return  object
     * @since   1.0.0
     */
    protected function scheduleFactoryMethod($product_name, $debug_type, array $options = array())
    {
        $message = $this->setDebugMessageFactoryMethod($product_name, $debug_type);

        $this->setDebugMethodCall($message . ' Started', $debug_type, __FILE__, __LINE__, $options);

        try {
            $product = $this->schedule->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {

            throw new RuntimeException(
                'Frontcontroller scheduleFactoryMethod Failed '
                . ' For Product: ' . $product_name . ' '
                . ' Exception Message: ' . $e->getMessage()
            );
        }

        $this->setDebugMethodCall($message . ' Finished', $debug_type, __FILE__, __LINE__);

        return $product;
    }

    /**
     * Set Debug Message for Factory Method
     *
     * @param   string $product_name
     * @param   string $debug_type
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setDebugMessageFactoryMethod($product_name, $debug_type)
    {
        return 'Class: ' . 'Molajo\Controller\FrontController)'
        . ' Method:' . 'scheduleFactoryMethod'
        . ' Type: ' . $debug_type
        . ' Product: ' . $product_name;
    }
}
