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
     * @return  mixed
     * @since   1.0.0
     */
    public function getCache($cache_key, $options)
    {
        $cache_instance = $this->scheduleCacheService($cache_key);

        $key = $this->verifyCacheKey('getCache', $options);

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
     */
    public function setCache($cache_key, $options)
    {
        $cache_instance = $this->scheduleCacheService($cache_key);

        $key = $this->verifyCacheKey('setCache', $options);

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
        $cache_instance = $this->scheduleCacheService($cache_key);

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

    /**
     * Schedule Cache Service
     *
     * @param   string $cache_key
     *
     * @return  object
     * @since   1.0.0
     */
    protected function scheduleCacheService($cache_key)
    {
        return $this->scheduleFactoryMethod($cache_key, 'Service');
    }

    /**
     * Verify Options Key
     *
     * @param   string $method_name
     * @param   array  $options
     *
     * @return  string
     * @since   1.0.0
     */
    protected function verifyCacheKey($method_name, array $options = array())
    {
        if (isset($options['key'])) {
            $key = $options['key'];
        } else {
            throw new RuntimeException('Frontcontroller ' . $method_name . ' method requires $options[key]');
        }

        return $key;
    }
}
