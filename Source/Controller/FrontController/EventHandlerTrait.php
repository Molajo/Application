<?php
/**
 * Event Handler Trait for Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\FrontController;

/**
 * Event Handler Trait for Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
trait EventHandlerTrait
{
    /**
     * Dependencies for Events
     *
     * @var    array
     * @since  1.0
     */
    protected $dependencies = array();

    /**
     * Schedule Event Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $event_callback;

    /**
     * Schedule Event Processing
     *
     * @param   string $event_name
     * @param   array  $options
     *
     * @return  array
     * @since   1.0.0
     */
    public function scheduleEvent($event_name, array $options = array())
    {
        if ($event_name === 'onBeforeInitialise') {
            return array();
        }

        $options['event_name'] = $event_name;
        $event_instance        = $this->scheduleFactoryMethod('Event', 'Service', $options);
        $dispatcher            = $this->scheduleFactoryMethod('Dispatch', 'Service', array());

        $message = $this->setDebugMessageScheduleEvent($event_name);

        $this->setDebugMethodCall($message . ' Started', $event_name, __FILE__, __LINE__, $options);

        $event_results = $dispatcher->scheduleEvent($event_name, $event_instance, $this->debug_callback);

        foreach ($event_results as $key => $value) {
            $new_key = $this->dependencies[$key];
            $this->setContainerEntry($new_key, $value);
        }

        $this->setDebugMethodCall($message . ' Finished', $event_name, __FILE__, __LINE__, $event_results);

        return $event_results;
    }

    /**
     * Set Debug Message for Schedule Event
     *
     * @param   string $event_name
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setDebugMessageScheduleEvent($event_name)
    {
        return 'Class: ' . 'Molajo\Controller\FrontController)'
        . ' Method:' . 'scheduleEvent'
        . ' Type: ' . 'Event'
        . ' Event Name: ' . $event_name;
    }

    /**
     * Create the Schedule Event Anonymous Function
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function createEventCallback()
    {
        $this->event_callback = function ($event_name, array $options = array()) {
            return $this->scheduleEvent($event_name, $options);
        };

        $this->setContainerEntry('Eventcallback', $this->event_callback);

        return $this;
    }

    /**
     * Store Product in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0.0
     */
    abstract protected function setContainerEntry($product_name, $value);

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
    abstract protected function scheduleFactoryMethod($product_name, $debug_type, array $options = array());

    /**
     * Set Debug Method Call
     *
     * @param  string  $message
     * @param  string  $debug_type
     * @param  string  $file
     * @param  integer $line
     * @param  array   $context
     *
     * @return  $this
     * @since   1.0.0
     */
    abstract protected function setDebugMethodCall($message, $debug_type, $file, $line, array $context = array());
}
