<?php
/**
 * Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\FrontControllerInterface;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\ScheduleInterface;
use Exception;

/**
 * Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class FrontController implements FrontControllerInterface
{
    /**
     * Factory Method Scheduling
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $queue;

    /**
     * Requests
     *
     * @var    array
     * @since  1.0
     */
    protected $requests;

    /**
     * Base Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path;

    /**
     * Front Controller Steps
     *
     * @var    array
     * @since  1.0
     */
    protected $steps
        = array(
            'initialise',
            'authenticate',
            'route',
            'authorise',
            'resourcecontroller',
            'execute',
            'response'
        );

    /**
     * Schedule Event Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $event_callback;

    /**
     * First Step
     *
     * @var    boolean
     * @since  1.0
     */
    protected $first_step = true;

    /**
     * Normal Ending
     *
     * @var    boolean
     * @since  1.0
     */
    protected $normal_ending = false;

    /**
     * Constructor
     *
     * @param  ScheduleInterface $queue
     * @param  array             $requests
     * @param  string            $base_path
     * @param  array             $steps
     *
     * @since  1.0
     */
    public function __construct(
        ScheduleInterface $queue,
        $requests,
        $base_path,
        array $steps = array()
    ) {
        $this->queue     = $queue;
        $this->requests  = $requests;
        $this->base_path = $base_path;

        if (count($steps) > 0) {
            $this->steps = $steps;
        }
    }

    /**
     * Request to Response Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function process()
    {
        foreach ($this->steps as $step) {
            $this->scheduleEvent($event_name = 'onBefore' . ucfirst(strtolower($step)));
            $this->runStep($step);
            $this->first_step = false;
            $this->scheduleEvent($event_name = 'onAfter' . ucfirst(strtolower($step)));
        }

        $this->normal_ending = true;

        restore_error_handler();

        return $this;
    }

    /**
     * Executed by the process loop for each process identified in $this->steps
     *
     * @param   string $factory_method
     *
     * @return  $this
     * @since   1.0
     */
    protected function runStep($factory_method)
    {
        if ($this->first_step === true) {
            return $this->initialise();
        }

        $results = $this->scheduleFactoryMethod($factory_method);

        if (isset($results->error_code) && (int)$results->error_code > 0) {
            trigger_error(E_ERROR, 'Frontcontroller::runStep Error for: ' . $factory_method);
        }

        return $this;
    }

    /**
     * Initialise
     *
     * @return  $this
     * @since   1.0
     */
    protected function initialise()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        set_error_handler(array($this, 'handleErrors'));
        set_exception_handler(array($this, 'handleExceptions'));
        register_shutdown_function(array($this, 'shutdown'));

        $this->createScheduleEventCallback();

        if (count($this->requests) > 0) {
            foreach ($this->requests as $request) {
                $this->scheduleFactoryMethod($request);
            }
        }

        return $this;
    }

    /**
     * Schedule Event Processing
     *
     * @param   string $event_name
     * @param   array  $options
     *
     * @return  FrontController
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function scheduleEvent($event_name, array $options = array())
    {
        if ($this->first_step === true) {
            return $this;
        }

        $options['event_name'] = $event_name;
        $event_instance        = $this->scheduleFactoryMethod('Event', $options);
        $dispatcher            = $this->scheduleFactoryMethod('Dispatcher');

        foreach ($dispatcher->scheduleEvent($event_name, $event_instance) as $key => $value) {
            $this->setContainerEntry($key, $options[$key]);
        }

        return $this;
    }

    /**
     * Schedule Factory recursively resolving dependencies
     *
     * @param   string $product_name
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0
     */
    public function scheduleFactoryMethod($product_name, array $options = array())
    {
        $options['base_path'] = $this->base_path;

        return $this->runFactoryMethod($product_name, $options);
    }

    /**
     * Store Instance in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   object $value
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setContainerEntry($product_name, $value)
    {
        $options          = array();
        $options['set']   = true;
        $options['value'] = $value;

        $this->runFactoryMethod($product_name, $options);

        return $this;
    }

    /**
     * Error Handling
     *
     * @param   integer $error_number
     * @param   string  $message
     * @param   string  $file
     * @param   integer $line_number
     *
     * @return  mixed|string
     * @since   1.0
     */
    public function handleErrors($error_number, $message, $file, $line_number)
    {
        $options                 = array();
        $options['error_number'] = $error_number;
        $options['message']      = $message;
        $options['file']         = $file;
        $options['line_number']  = $line_number;

        return $this->queue->scheduleFactoryMethod('ErrorHandler')->handleError($options);
    }

    /**
     * Run Factory Method
     *
     * @param   string $product_name
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function runFactoryMethod($product_name, array $options)
    {
        try {
            return $this->queue->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {
            throw new RuntimeException('Frontcontroller scheduleFactoryMethod Failed ' . $e->getMessage());
        }
    }

    /**
     * Shutdown the application
     *
     * @return  void
     * @since   1.0
     */
    public function shutdown()
    {
        $error = error_get_last();

        if (headers_sent() && $this->normal_ending) {
        } else {
            header('HTTP/1.1 500 Internal Server Error');
        }

        if ($this->normal_ending) {
        } else {
            echo 'Failed Run';
        }

        exit(0);
    }

    /**
     * Create the Schedule Event Anonymous Function
     *
     * @return  $this
     * @since   1.0
     */
    protected function createScheduleEventCallback()
    {
        /**
         * Schedule Event Processing
         *
         * @param   string $event_name
         * @param   array  $options
         *
         * @return  array
         * @since   1.0
         */
        $this->event_callback = function ($event_name, array $options = array()) {
            return $this->scheduleEvent($event_name, $options);
        };

        $this->setContainerEntry('Eventcallback', $this->event_callback);

        return $this;
    }
}
