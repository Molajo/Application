<?php
/**
 * Cache Handler Trait for Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\FrontController;

use CommonApi\Exception\RuntimeException;

/**
 * Cache Handler Trait for Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
trait CacheHandlerTrait
{
    /**
     * Get Cache Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $get_cache_callback;

    /**
     * Set Cache Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $set_cache_callback;

    /**
     * Delete Cache Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $delete_cache_callback;

    /**
     * Get Cache Value
     *
     * @param   string $cache_key
     * @param   array  $options
     *
     * @return  object CommonApi\Cache\CacheItemInterface
     * @since   1.0.0
     */
    public function getCache($cache_key, $options)
    {
        $cache_instance = $this->scheduleFactoryMethod($cache_key, 'Service');

        if (isset($options['key'])) {
            $key = $options['key'];
        } else {
            throw new RuntimeException('Frontcontroller getCache method requires $options[key]');
        }

        return $cache_instance->get($key);
    }

    /**
     * Set Cache Value
     *
     * @param   string $cache_key
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setCache($cache_key, $options)
    {
        $cache_instance = $this->scheduleFactoryMethod($cache_key, 'Service');

        if (isset($options['key'])) {
            $key = $options['key'];
        } else {
            throw new RuntimeException('Frontcontroller getCache method requires $options[key]');
        }

        if (isset($options['value'])) {
            $value = $options['value'];
        } else {
            $value = null;
        }

        $cache_instance->set($key, $value);

        return $this;
    }

    /**
     * Delete Cache Key or Clear Cache
     *
     * @param   string $cache_key
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function deleteCache($cache_key, $options)
    {
        $cache_instance = $this->scheduleFactoryMethod($cache_key, 'Service');

        if (isset($options['key'])) {
            $cache_instance->remove($options['key']);
        } else {
            $cache_instance->clear();
        }

        return $this;
    }

    /**
     * Create the Cache Anonymous Function
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function createCacheCallbacksOn()
    {
        $this->get_cache_callback = function ($cache_key, array $options = array()) {
            return $this->getCache($cache_key, $options);
        };

        $this->set_cache_callback = function ($cache_key, array $options = array()) {
            return $this->setCache($cache_key, $options);
        };

        $this->delete_cache_callback = function ($cache_key, array $options = array()) {
            return $this->deleteCache($cache_key, $options);
        };

        return $this->setContainerCacheCallbacks();
    }

    /**
     * Create the Cache Anonymous Function
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function createCacheCallbacksOff()
    {
        $this->get_cache_callback    = '';
        $this->set_cache_callback    = '';
        $this->delete_cache_callback = '';

        return $this->setContainerCacheCallbacks();
    }

    /**
     * Create the Cache Anonymous Function
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setContainerCacheCallbacks()
    {
        $this->setContainerEntry('Getcachecallback', $this->get_cache_callback);
        $this->setContainerEntry('Setcachecallback', $this->set_cache_callback);
        $this->setContainerEntry('Deletecachecallback', $this->delete_cache_callback);

        return $this;
    }
}
