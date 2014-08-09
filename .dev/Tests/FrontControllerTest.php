<?php
/**
 * FrontController Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Event\DispatcherInterface;
use CommonApi\Event\EventInterface;
use CommonApi\IoC\ScheduleInterface;
use Molajo\Controller\FrontController;
use stdClass;

/**
 * FrontController Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class FrontControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * IoCC
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $queue;

    /**
     * Dispatcher
     *
     * @var    object  CommonApi\Event\DispatcherInterface
     * @since  1.0
     */
    protected $dispatcher;

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
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    protected function setUp()
    {
        $this->dispatcher = new MockDispatcher();
        $this->queue      = new MockScheduler($this->dispatcher);
        $this->base_path  = __DIR__;

        $this->fc = new FrontController(
            $this->queue,
            $this->requests,
            $this->base_path,
            $this->steps
        );

        return $this;
    }

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    public function testVerifyIoCCProdcuts()
    {
        $results = $this->fc->process();

        $expected = array(
            'Eventcallback',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'authenticate',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'route',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'authorise',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'resourcecontroller',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'execute',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'response',
            'Event',
            'Dispatcher'
        );

        $this->assertEquals($expected, $this->queue->scheduled_products);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    public function testVerifyEvents()
    {
        $results = $this->fc->process();

        $expected = array(
            'onAfterInitialise',
            'onBeforeAuthenticate',
            'onAfterAuthenticate',
            'onBeforeRoute',
            'onAfterRoute',
            'onBeforeAuthorise',
            'onAfterAuthorise',
            'onBeforeResourcecontroller',
            'onAfterResourcecontroller',
            'onBeforeExecute',
            'onAfterExecute',
            'onBeforeResponse',
            'onAfterResponse'
        );

        $this->assertEquals($expected, $this->dispatcher->event_list);

        return $this;
    }
}


class MockDispatcher implements DispatcherInterface
{
    public $event_list = array();

    protected $event_option_keys
        = array(
            'exclude_tokens',
            'model_registry',
            'parameters',
            'plugin_data',
            'query_results',
            'query',
            'rendered_page',
            'rendered_view',
            'row',
            'runtime_data',
            'token_objects',
            'user'
        );

    /**
     * Initialise Options Array for Event
     *
     * @return  array
     * @since   1.0
     */
    public function initializeEventOptions()
    {
        $options = array();

        foreach ($this->event_option_keys as $key) {
            $options[$key] = null;
        }

        return $options;
    }


    public function registerForEvent($event_name, $callback, $priority = 50)
    {

    }

    public function scheduleEvent($event_name, EventInterface $event)
    {
        $this->event_list[] = $event_name;
        return array();
    }
}

/**
 * Event
 */
class MockEvent implements EventInterface
{
    public function get($key)
    {

    }

    public function set($key, $value)
    {

    }
}

/**
 * Injection of Control
 *
 * @package Molajo\Controller\Test
 */
class MockScheduler implements ScheduleInterface
{
    public $scheduled_products = array();

    protected $dispatcher;

    protected $event_option_keys
        = array(
            'runtime_data',
            'plugin_data',
            'parameters',
            'model_registry',
            'query_results',
            'row',
            'rendered_view',
            'rendered_page',
            'token'
        );

    public function __construct(
        $dispatcher
    ) {
        $this->dispatcher = $dispatcher;
    }

    public function scheduleFactoryMethod($product_name, array $options = array())
    {
        $this->scheduled_products[] = $product_name;

        if (strtolower($product_name) === 'authenticate') {

        } elseif (strtolower($product_name) === 'event') {
            return new MockEvent();

        } elseif (strtolower($product_name) === 'authorise') {

        } elseif (strtolower($product_name) === 'eventcallback') {

        } elseif (strtolower($product_name) === 'errorhandling') {

        } elseif (strtolower($product_name) === 'dispatcher') {
            return $this->dispatcher;

        } elseif (strtolower($product_name) === 'execute') {

        } elseif (strtolower($product_name) === 'resource') {

        } elseif (strtolower($product_name) === 'response') {

        } elseif (strtolower($product_name) === 'resourcecontroller') {

        } elseif (strtolower($product_name) === 'route') {

        } elseif (strtolower($product_name) === 'runtimedata') {

            $runtime_data                           = new stdClass();
            $runtime_data->error_code               = 0;
            $runtime_data->redirect_to_id           = 0;
            $runtime_data->base_path                = $this->options['base_path'];
            $runtime_data->event_options_keys       = $this->event_option_keys;
            $runtime_data->request                  = new stdClass();
            $runtime_data->request->data            = new stdClass();
            $runtime_data->request->client          = new stdClass();
            $runtime_data->request->server          = new stdClass();
            $runtime_data->site                     = new stdClass();
            $runtime_data->application              = new stdClass();
            $runtime_data->route                    = new stdClass();
            $runtime_data->user                     = new stdClass();
            $runtime_data->reference_data           = new stdClass();
            $runtime_data->resource                 = new stdClass();
            $runtime_data->resource->data           = new stdClass();
            $runtime_data->resource->parameters     = new stdClass();
            $runtime_data->resource->model_registry = new stdClass();
            $runtime_data->render                   = new stdClass();

            return $runtime_data;

        } elseif (strtolower($product_name) === 'user') {

        }
    }
}
