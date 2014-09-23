<?php
/**
 * Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ErrorHandlingInterface;
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
class FrontController implements FrontControllerInterface, ErrorHandlingInterface
{
    /**
     * Factory Method Scheduling
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $schedule;

    /**
     * Factory Method Requests
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
    protected $steps = array();

    /**
     * Dependencies for Events
     *
     * @var    array
     * @since  1.0
     */
    protected $dependencies_array = array();

    /**
     * Error Handler
     *
     * @var    object  CommonApi\Controller\ErrorHandlingInterface
     * @since  1.0
     */
    protected $error_handler;

    /**
     * Exception Handler
     *
     * @var    object
     * @since  1.0
     */
    protected $exception_handler;

    /**
     * Debug Handler
     *
     * @var    object  CommonApi\Controller\ErrorHandlingInterface
     * @since  1.0
     */
    protected $debug_handler;

    /**
     * Debug Types
     *
     * @var    array
     * @since  1.0
     */
    protected $debug_types = array();

    /**
     * Function to capture debug trace log
     *
     * @var    callable
     * @since  1.0
     */
    protected $debug_callback;

    /**
     * Schedule Event Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $event_callback;

    /**
     * Normal Ending
     *
     * @var    boolean
     * @since  1.0
     */
    protected $normal_ending = false;

    /**
     * First Step
     *
     * @var    boolean
     * @since  1.0
     */
    protected $first_step = true;

    /**
     * Constructor
     *
     * @param  ScheduleInterface      $schedule
     * @param  array                  $requests
     * @param  string                 $base_path
     * @param  array                  $steps
     * @param  array                  $dependencies
     * @param  ErrorHandlingInterface $error_handler
     * @param  null                   $exception_handler
     * @param  boolean                $debug
     * @param  array                  $debug_types
     * @param  ErrorHandlingInterface $debug_handler
     *
     * @since  1.0
     */
    public function __construct(
        ScheduleInterface $schedule,
        $requests,
        $base_path,
        array $steps = array(),
        array $dependencies = array(),
        ErrorHandlingInterface $error_handler = null,
        $exception_handler = null,
        $debug = false,
        array $debug_types = array(),
        ErrorHandlingInterface $debug_handler = null
    ) {
        $this->schedule           = $schedule;
        $this->requests           = $requests;
        $this->base_path          = $base_path;
        $this->steps              = $steps;
        $this->dependencies_array = $dependencies;

        $this->setErrorHandler($error_handler);
        $this->setExceptionHandler($exception_handler);
        $this->setDebugHandler($debug_handler, $debug_types, $debug);
        $this->createScheduleEventCallback();
    }

    /**
     * Execute Application: Request to Response Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function process()
    {
        register_shutdown_function(array($this, 'shutdown'));

        foreach ($this->steps as $step) {
            $this->scheduleEvent($event_name = 'onBefore' . ucfirst(strtolower($step)));
            $this->runStep($step);
            $this->first_step = false;
            $this->scheduleEvent($event_name = 'onAfter' . ucfirst(strtolower($step)));
        }

        $this->normal_ending = true;

        restore_error_handler();
        $this->shutdown();
    }

    /**
     * Schedule Event Processing
     *
     * @param   string $event_name
     * @param   array  $options
     *
     * @return  array
     * @since   1.0
     */
    public function scheduleEvent($event_name, array $options = array())
    {
        if ($this->first_step === true) {
            return $this;
        }

        $options['event_name'] = $event_name;
        $event_instance        = $this->scheduleFactoryMethod('Event', 'Service', $options);
        $dispatcher            = $this->scheduleFactoryMethod('Dispatch', 'Service', array());

        $message = 'Class: ' . __CLASS__ . ' Method:' . __METHOD__ . ' Type: Event: ' . $event_name;

        $this->setDebugMethodCall(
            $message . ' Started',
            $event_name,
            array('file' => __FILE__, 'line' => __LINE__)
        );

        $event_results = $dispatcher->scheduleEvent($event_name, $event_instance, $this->debug_callback);

        foreach ($event_results as $key => $value) {
            $new_key = $this->dependencies_array[$key];
            $this->setContainerEntry($new_key, $value);
        }

        $this->setDebugMethodCall(
            $message . ' Finished',
            $event_name,
            array('file' => __FILE__, 'line' => __LINE__)
        );

        return $event_results;
    }

    /**
     * Method is called by PHP for errors if it has been assigned the PHP set_error_handler in the application
     *
     * @param   integer $error_number
     * @param   string  $message
     * @param   string  $file
     * @param   integer $line_number
     * @param   array   $context
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setError($error_number, $message, $file, $line_number, array $context = array())
    {
        echo 'in frontcontroller setError <br>';
        echo '<pre>';
        var_dump(array($error_number, $message, $file, $line_number, $context));
        echo '</pre>';
        die;
        $this->error_handler->setError($error_number, $message, $file, $line_number, $context);

        return $this;
    }

    /**
     * Method is called by PHP for errors if it has been assigned the PHP set_error_handler in the application
     *
     * @param   Exception $e
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setException(Exception $e)
    {
        echo 'Exception';
        echo '<pre>';
        var_dump($e);
        die;
        $options              = array();
        $options['exception'] = $e;

        $this->exception_handler->handleException($options);

        return $this;
    }

    /**
     * Method is called by PHP for errors if it has been assigned the PHP set_error_handler in the application
     *
     * @param   string $message
     * @param   array  $context
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setDebug($message, array $context = array())
    {
        $this->debug_handler->log(100, $message, $context);

        return $this;
    }

    /**
     * Shutdown the application
     *
     * @return  void
     * @since   1.0
     */
    public function shutdown()
    {
        if (headers_sent()) {
        } else {
            header('HTTP/1.1 500 Internal Server Error');
        }

        if ($this->normal_ending === true) {
        } else {
            echo 'Failed Run.';
        }

        exit(0);
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

        $results = $this->scheduleFactoryMethod($factory_method, 'Step');

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
        if (count($this->requests) > 0) {
            foreach ($this->requests as $request) {
                $this->scheduleFactoryMethod($request, 'Initialise');
            }
        }

        return $this;
    }

    /**
     * Store Product in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0
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
     * @since   1.0
     */
    protected function scheduleFactoryMethod($product_name, $debug_type, array $options = array())
    {
        $options['base_path'] = $this->base_path;

        $message = 'Class: ' . __CLASS__ .
            ' Method:' . __METHOD__ .
            ' Type: ' . $debug_type .
            ' Product: ' . $product_name;

        $this->setDebugMethodCall(
            $message . ' Started',
            $debug_type,
            array('file' => __FILE__, 'line' => __LINE__)
        );

        try {
            $product = $this->schedule->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {

            throw new RuntimeException(
                'Frontcontroller scheduleFactoryMethod Failed '
                . ' For Product: ' . $product_name . ' '
                . ' Exception Message: ' . $e->getMessage()
            );
        }

        $this->setDebugMethodCall(
            $message . ' Finished',
            $debug_type,
            array('file' => __FILE__, 'line' => __LINE__)
        );

        return $product;
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

    /**
     * Establish the Error Handler for Application
     *
     * @param   null|ErrorHandlingInterface $error_handler
     *
     * @return  $this
     * @since   1.0
     */
    protected function setErrorHandler(ErrorHandlingInterface $error_handler = null)
    {
        if ($error_handler === null) {
            $error_handler = $this->scheduleFactoryMethod('Errorhandling', 'Service');
        }

        $this->error_handler = $error_handler;

        set_error_handler(array($this, 'setError'));
        error_reporting(E_ALL & ~E_NOTICE);

        return $this;
    }

    /**
     * Establish the Error Handler for Application
     *
     * @param   null|object $exception_handler
     *
     * @return  $this
     * @since   1.0
     */
    protected function setExceptionHandler($exception_handler = null)
    {
        if ($exception_handler === null) {
            $exception_handler = $this->scheduleFactoryMethod('Exceptionhandling', 'Service');
        }

        $this->exception_handler = $exception_handler;

        set_exception_handler(array($this, 'setException'));

        return $this;
    }

    /**
     * Establish the Debug Handler for Application
     *
     * @param   null|ErrorHandlingInterface $debug_handler
     * @param   array                       $debug_types
     * @param   boolean                     $debug
     *
     * @return  $this
     * @since   1.0
     */
    protected function setDebugHandler(
        ErrorHandlingInterface $debug_handler = null,
        array $debug_types = array(),
        $debug = false
    ) {
        if ($debug === true) {
        } else {
            $this->debug_types = array();

            return $this;
        }

        if ($debug_handler === null) {
            $debug_handler = $this->scheduleFactoryMethod('Debug', 'Service');
        }

        $this->debug_types   = $debug_types;
        $this->debug_handler = $debug_handler;

        $this->setDebugCallback();

        return $this;
    }

    /**
     * Create Debug Callback for use with Application Logging
     *
     * @return  $this
     * @since   1.0
     */
    protected function setDebugCallback()
    {
        /**
         * Function can be used to capture debug trace log within Application
         *
         * @param   string $message
         * @param   string $debug_type
         * @param   array  $context
         *
         * @return  $this
         * @since   1.0.0
         */
        $this->debug_callback = function ($message, $debug_type, array $context = array()) {

            if (in_array($debug_type, $this->debug_types)) {
                $this->setDebugMethodCall($message, $debug_type, $context);
            }

            return $this;
        };

        $this->setContainerEntry('Debugcallback', $this->debug_callback);

        return $this;
    }

    /**
     * Set Debug Method Call
     *
     * @param  string $message
     * @param  string $debug_type
     * @param  array  $context
     *
     * @return  $this
     * @since   1.0
     */
    protected function setDebugMethodCall($message, $debug_type, array $context = array())
    {
        if (in_array($debug_type, $this->debug_types)) {
            $context['debug_type'] = $debug_type;
            $this->setDebug($message, $context);
        }

        return $this;
    }
}
