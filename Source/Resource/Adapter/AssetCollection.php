<?php
/**
 * Asset Collection Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use stdClass;

/**
 * Asset Collection Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
abstract class AssetCollection extends Assets
{
    /**
     * Retrieve a collection of a specific handler
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function getCollection($scheme, array $options = array())
    {
        $defer = $this->getDeferRequest($scheme, $options);

        $priorities = $this->getAssetPriorities($scheme, $defer);

        $priority_order = array();

        foreach ($priorities as $priority) {
            foreach ($this->asset_array as $row) {
                $priority_order = $this->testCollectionRow($scheme, $priority, $defer, $row, $priority_order);
            }
        }

        return $priority_order;
    }

    /**
     * Test for inclusion in Collection
     *
     * @param   string  $scheme
     * @param   string  $priority
     * @param   boolean $defer
     * @param   object  $row
     * @param   array   $priority_order
     *
     * @return  array
     * @since   1.0.0
     */
    public function testCollectionRow($scheme, $priority, $defer, $row, $priority_order)
    {
        if ((int) $row->priority === (int) $priority) {
        } else {
            return $priority_order;
        }

        if (strtolower($scheme) === 'css') {
            $priority_order[] = $row;
            return $priority_order;
        }

        if ((int) $defer === (int) $row->defer) {
            $priority_order[] = $row;
        }

        return $priority_order;
    }

    /**
     * Develop a unique list of priorities in priority order
     *
     * @param   string $scheme
     * @param   string $defer
     *
     * @return  array
     * @since   1.0.0
     */
    protected function getAssetPriorities($scheme, $defer = 0)
    {
        if (is_array($this->asset_array) && count($this->asset_array) > 0) {
        } else {
            return array();
        }

        $priorities = array();

        foreach ($this->asset_array as $row) {

            if (strtolower($scheme) === 'css') {
                $priorities[] = $row->priority;

            } else {

                if ((int) $defer === (int) $row->defer) {
                    $priorities[] = $row->priority;
                }
            }
        }

        $priorities = array_unique($priorities);
        sort($priorities);

        return $priorities;
    }

    /**
     * For JS collections, determine if defer is requested
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  array
     * @since   1.0.0
     */
    protected function getDeferRequest($scheme, $options)
    {
        if (strtolower($scheme) === 'js') {
        } else {
            return 0;
        }

        if (isset($options['defer'])) {
        } else {
            return 0;
        }

        if ((int) $options['defer'] === 1) {
            return 1;
        }

        return 0;
    }
}
