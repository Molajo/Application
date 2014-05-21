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
    protected $steps = array();

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
        array $steps = array(
            'initialise',
            'authenticate',
            'route',
            'authorise',
            'resourcecontroller',
            'execute',
            'response'
        )
    ) {
        $this->queue     = $queue;
        $this->requests  = $requests;
        $this->base_path = $base_path;
        $this->steps     = $steps;
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
            $this->scheduleEvent($event_name = 'onBefore' . ucfirst(strtolower($step)));
            $this->runStep($step);
            $this->scheduleEvent($event_name = 'onAfter' . ucfirst(strtolower($step)));
            $this->first_step = false;
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

        try {
            $results = $this->scheduleFactoryMethod($factory_method);

        } catch (Exception $e) {
            throw new RuntimeException('Frontcontroller ' . $factory_method . ' Method Failed: ' . $e->getMessage());
        }

        if (isset($results->error_code) && (int)$results->error_code > 0) {
            $this->handleErrors();
        }

        return $this;
    }

    /**
     * Initialise
     *
     * @return  $this
     * @since   1.0
     */
    public function initialise()
    {
        $this->createScheduleEventCallback();

        foreach ($this->requests as $request) {

            try {
                $this->scheduleFactoryMethod($request);

            } catch (Exception $e) {
                throw new RuntimeException(
                    'Frontcontroller Initialise Schedule Factory Failed for '
                    . $request . ' ' . $e->getMessage()
                );
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
        $event_instance        = $this->scheduleEventCreateScheduled($options);
        $event_results         = $this->scheduleDispatcher($event_name, $event_instance);

        $this->scheduleEventSaveResults($event_results);

        return $this;
    }

    /**
     * Create Event Scheduled Instance
     *
     * @param   array $options
     *
     * @return  object
     * @since   1.0
     */
    protected function scheduleEventCreateScheduled(array $options = array())
    {
        try {
            return $this->scheduleFactoryMethod('Event', $options);

        } catch (Exception $e) {
            throw new RuntimeException(
                'Frontcontroller scheduleEvent Get Event Factory Failed: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create Event Scheduled Instance
     *
     * @param   string $event_name
     * @param   object $event_instance
     *
     * @return  array
     * @since   1.0
     */
    protected function scheduleDispatcher($event_name, $event_instance)
    {
        try {
            return $this->scheduleFactoryMethod('Dispatcher')->scheduleEvent($event_name, $event_instance);

        } catch (Exception $e) {
            throw new RuntimeException('Frontcontroller scheduleEvent Failed ' . $e->getMessage());
        }
    }

    /**
     * Retrieve Data from Event and save to container
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     */
    protected function scheduleEventSaveResults(array $options = array())
    {
        foreach ($options as $key => $value) {
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
        try {
            $options['base_path'] = $this->base_path;

            return $this->queue->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {
            throw new RuntimeException('Frontcontroller scheduleFactoryMethod Failed ' . $e->getMessage());
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
            throw new RuntimeException('Frontcontroller setContainerEntry Failed ' . $e->getMessage());
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
        $this->scheduleFactoryMethod('ErrorHandling');
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
