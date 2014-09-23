<?php
/**
 * Mock Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\IoC\ScheduleInterface;
use stdClass;

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

        } elseif (strtolower($product_name) === 'dispatcher') {

        } elseif (strtolower($product_name) === 'route') {

        } elseif (strtolower($product_name) === 'runtimedata') {

            $runtime_data                           = new stdClass();
            $runtime_data->error_code               = 0;
            $runtime_data->redirect_to_id           = 0;
            $runtime_data->base_path                = $this->base_path;
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
