<?php
/**
 * Mock Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Event\DispatcherInterface;
use CommonApi\Event\EventInterface;

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
            'token_objects'
        );

    /**
     * Initialise Options Array for Event
     *
     * @return  array
     * @since   1.0.0
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
     * Listener registers for an Event with the Dispatcher
     *
     * @param   string $event_name
     * @param   object $callback
     * @param   int    $priority 0 (lowest) to 100 (highest)
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function registerForEvent($event_name, $callback, $priority = 50)
    {

    }

    /**
     * Requester Schedules Event with Dispatcher
     *
     * @param   string         $event_name
     * @param   EventInterface $event CommonApi\Event\EventInterface
     *
     * @return  $this
     * @since   1.0.0
     */
    public function scheduleEvent($event_name, EventInterface $event)
    {
        $this->event_list[] = $event_name;
        return array();
    }
}
