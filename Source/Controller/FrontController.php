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
    protected $steps
        = array(
            'Initialise',
            'Route',
            'Authorisation',
            'Resourcecontroller',
            'Execute',
            'Response'
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
     * Debug Mode
     *
     * @var    boolean
     * @since  1.0
     */
    protected $debug = true;

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
     * @param  ScheduleInterface $schedule
     * @param  array             $requests
     * @param  string            $base_path
     * @param  array             $steps
     * @param  boolean           $debug
     *
     * @since  1.0
     */
    public function __construct(
        ScheduleInterface $schedule,
        $requests,
        $base_path,
        array $steps = array(),
        $debug = false
    ) {
        $this->schedule  = $schedule;
        $this->requests  = $requests;
        $this->base_path = $base_path;
        $this->debug     = $debug;

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

            if ($this->first_step === false) {
                $this->scheduleEvent($event_name = 'onBefore' . ucfirst(strtolower($step)));
            }

            $this->runStep($step);

            $this->first_step = false;
            $this->scheduleEvent($event_name = 'onAfter' . ucfirst(strtolower($step)));
        }

        $this->normal_ending = true;

        restore_error_handler();

        $this->shutdown();
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
     * Schedule Event Processing
     *
     * @param   string $event_name
     * @param   array  $options
     *
     * @return  FrontController
     * @since   1.0
     */
    public function scheduleEvent($event_name, array $options = array())
    {
        //todo: replace this and the event factory array
        $dependencies_array = array(
            'runtime_data'   => 'Runtimedata',
            'plugin_data'    => 'Plugindata',
            'parameters'     => 'parameters',
            'row'            => 'row',
            'query'          => 'query',
            'model_registry' => 'model_registry',
            'query_results'  => 'query_results',
            'rendered_view'  => 'rendered_view',
            'rendered_page'  => 'rendered_page',
            'user'           => 'User',
            'exclude_tokens' => 'exclude_tokens',
            'token_objects'  => 'token_objects'
        );

        if ($this->first_step === true) {
            return $this;
        }

        $options['event_name'] = $event_name;
        $event_instance        = $this->scheduleFactoryMethod('Event', $options);
        $dispatcher            = $this->scheduleFactoryMethod('Dispatcher');
        $event_results         = $dispatcher->scheduleEvent($event_name, $event_instance);

        foreach ($event_results as $key => $value) {
            $new_key = $dependencies_array[$key];
            $this->setContainerEntry($new_key, $value);
        }


        return $event_results;
    }

    /**
     * Schedule Factory recursively resolving dependencies
     *
     * @param   string $product_name
     * @param   array  $options
     *
     * @return  FrontController
     * @since   1.0
     */
    public function scheduleFactoryMethod($product_name, array $options = array())
    {
        /***
         * if ($this->debug === true) {
         *
         * $log_level = 100;
         * $class = 'Molajo\\Controller\\FrontController';
         * $method = 'scheduleFactoryMethod';
         * $product = $product_name;
         *
         * trigger_error('Frontcontroller::initialise scheduleFactoryMethod for: ' . $product_name, E_USER_NOTICE);
         * }
         */
        $instance = $this->runFactoryMethod($product_name, $options);

        return $instance;
    }

    /**
     * Store Instance in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   object $value
     *
     * @return  $this
     * @since   1.0
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
     * Run Factory Method
     *
     * @param   string $product_name
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0
     */
    protected function runFactoryMethod($product_name, array $options = array())
    {
        $options['base_path'] = $this->base_path;

        try {
            return $this->schedule->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {
            throw new RuntimeException('Frontcontroller scheduleFactoryMethod Failed ' . $e->getMessage());
        }
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
        set_error_handler(array($this, 'setError'));
        set_exception_handler(array($this, 'setException'));
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
        echo 'xxxxIn setErrorxxxx<br>';
        echo '<pre>';
        var_dump(
            array(
                $error_number,
                $message,
                $file,
                $line_number,
                $context
            )
        );
        die;
        $this->schedule->scheduleFactoryMethod('Errorhandling')
            ->setError($error_number, $message, $file, $line_number, $context);
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
        echo 'xxxxIn Frontcontroller setExceptionxxxx<br>';
        echo '<pre>';
        var_dump(
            array(
                $e
            )
        );
        die;
        $options              = array();
        $options['exception'] = $e;
        $options['base_path'] = $this->base_path;

        return $this->schedule->scheduleFactoryMethod('Exceptionhandling')->handleException($options);
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
