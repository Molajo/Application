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
 * @since      1.0
 */
class FrontController implements FrontControllerInterface, ScheduleInterface
{
    /**
     * Factory Method Scheduling
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $queue;

    /**
     *  Services
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
    protected $steps = array('initialise', 'route', 'execute', 'response');

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
     * Constructor
     *
     * @param  ScheduleInterface $queue
     * @param  array             $requests
     * @param  string            $base_path
     *
     * @since  1.0
     */
    public function __construct(
        ScheduleInterface $queue,
        $requests,
        $base_path
    ) {
        $this->queue     = $queue;
        $this->requests  = $requests;
        $this->base_path = $base_path;
    }

    /**
     * Request to Response Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function process()
    {
        set_error_handler(array($this, 'handleErrors'));
        register_shutdown_function(array($this, 'shutdown'));

        foreach ($this->steps as $step) {

            if ($this->first_step === true) {
            } else {
                $this->scheduleEvent($event_name = 'onBefore' . ucfirst(strtolower($step)));
            }

            try {
                $this->$step();

            } catch (Exception $e) {
                throw new RuntimeException ($e->getMessage());
            }

            $this->scheduleEvent($event_name = 'onAfter' . ucfirst(strtolower($step)));

            $this->first_step = false;
        }

        define('NormalEnding', true);

        restore_error_handler();

        return $this;
    }

    /**
     * Schedule Event Processing
     *
     * @param   string $event_name
     * @param   array  $options
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function scheduleEvent($event_name, array $options = array())
    {
        $options['event_name'] = $event_name;

        try {
            $event_instance = $this->scheduleFactoryMethod('Event', $options);

        } catch (Exception $e) {
            throw new RuntimeException
            ('Frontcontroller scheduleEvent Get Event Factory Failed: ' . $e->getMessage());
        }

        try {
            $results = $this->scheduleFactoryMethod('Dispatcher')->scheduleEvent($event_name, $event_instance);

        } catch (Exception $e) {
            throw new RuntimeException ('Frontcontroller scheduleEvent Failed ' . $e->getMessage());
        }

        if (count($results) > 0) {
            foreach ($results as $key => $value) {
                $this->setContainerEntry($key, $results[$key]);
            }
        }

        return $results;
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
        try {
            $options['base_path'] = $this->base_path;

            return $this->queue->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {
            throw new RuntimeException ('Frontcontroller scheduleFactoryMethod Failed ' . $e->getMessage());
        }
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

        try {
            $this->queue->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {
            throw new RuntimeException ('Frontcontroller setContainerEntry Failed ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * Error Handling
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function handleErrors()
    {
        //$this->scheduleFactoryMethod('ErrorHandling');
        /**
         *
         * $this->redirect->set('url', $runtime_data->redirect_to_id);
         * $this->redirect->set('status_code', 301);
         * $this->redirect->redirect();
         *
         * ob_start();
         * if ( is_callable($this->error) ) {
         * call_user_func_array($this->error, array($argument));
         * } else {
         * call_user_func_array(array($this, 'defaultError'), array($argument));
         * }
         *
         * return ob_get_clean();
         */
    }

    /**
     * Shutdown the application
     *
     * @return  void
     * @since   1.0
     */
    public function shutdown()
    {
        if (defined('NormalEnding')) {
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

    /**
     * Initialise
     *
     * @return  $this
     * @since   1.0
     */
    protected function initialise()
    {
        $this->createScheduleEventCallback();

        foreach ($this->requests as $request) {
            try {
                $this->scheduleFactoryMethod($request);

            } catch (Exception $e) {
                throw new RuntimeException ('Frontcontroller Initialise Schedule Factory Failed for '
                . $request . ' ' . $e->getMessage());
            }
        }

        return $this;
    }

    /**
     * Route the Application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function route()
    {
        try {
            $results = $this->scheduleFactoryMethod('Route');

        } catch (Exception $e) {
            throw new RuntimeException ('Frontcontroller Route Method Failed: ' . $e->getMessage());
        }

        if (isset($results->error_code) && (int)$results->error_code > 0) {
            $this->handleErrors();
        }

        return $this;
    }

    /**
     * Execute Route
     *
     * @return  $this
     * @since   1.0
     */
    protected function execute()
    {
        if ($this->scheduleFactoryMethod('Runtimedata')->route->method == 'GET') {
            $this->scheduleFactoryMethod('Render')->render();
        }

        // create

        // update

        // delete

        // redirect

        return $this;
    }

    /**
     * Execute Response
     *
     * @return  $this
     * @since   1.0
     */
    protected function response()
    {
        if ($this->scheduleFactoryMethod('Runtimedata')->route->method == 'GET') {
        } else {
            return $this;
        }

        $this->scheduleFactoryMethod('Response')->send();

        return $this;
    }
}
