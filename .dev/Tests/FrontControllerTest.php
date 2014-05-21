<?php
/**
 * FrontController Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Render\EventInterface;
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
            'resource',
            'execute',
            'response'
        );

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleEventCreateScheduled
     * @covers  Molajo\Controller\FrontController::scheduleDispatcher
     * @covers  Molajo\Controller\FrontController::scheduleEventSaveResults
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
        $this->queue = new MockSchedule();

        $this->base_path = __DIR__;

        $this->fc = new FrontController(
            $this->queue,
            $this->requests,
            $this->base_path
        );

        return $this;
    }

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleEventCreateScheduled
     * @covers  Molajo\Controller\FrontController::scheduleDispatcher
     * @covers  Molajo\Controller\FrontController::scheduleEventSaveResults
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    public function testProcessSeeThatItFinishes()
    {
        $this->queue = new MockSchedule();

        $this->fc = new FrontController(
            $this->queue,
            array(),
            $this->base_path
        );

        $results = $this->fc->process();

        $this->assertEquals(1, 1);

        return $this;
    }

    /**
     * Tear down
     *
     * @return  $this
     * @since   1.0
     */
    protected function tearDown()
    {

    }
}

class MockSchedule implements ScheduleInterface
{
    protected $dispatcher;
    protected $resource_controller;

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

    public function __construct()
    {
        $this->dispatcher = new MockDispatcher();
        $this->resource_controller = new MockResourceController();
    }

    public function scheduleFactoryMethod($product_name, array $options = array())
    {
        if (strtolower($product_name) === 'authenticate') {

        } elseif (strtolower($product_name) === 'event') {

        } elseif (strtolower($product_name) === 'authorise') {

        } elseif (strtolower($product_name) === 'eventcallback') {

        } elseif (strtolower($product_name) === 'errorhandling') {

        } elseif (strtolower($product_name) === 'dispatcher') {
            return $this->dispatcher;

        } elseif (strtolower($product_name) === 'execute') {

        } elseif (strtolower($product_name) === 'resource') {

        } elseif (strtolower($product_name) === 'response') {

        } elseif (strtolower($product_name) === 'resourcecontroller') {
            return $this->resource_controller;

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


class MockDispatcher implements EventInterface
{
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

    /**
     * Schedule Event
     *
     * @param   string $event_name
     * @param   array  $options
     *
     * @return  array
     * @since   1.0
     */
    public function scheduleEvent($event_name, array $options = array())
    {

    }
}
class MockResourceController
{

    public function getResource($resource_namespace, $multiple = false)
    {

    }
}
