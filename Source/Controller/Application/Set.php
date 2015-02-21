<?php
/**
 * Set Application
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Application;

use stdClass;

/**
 * Set Application
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class Set extends Base
{
    /**
     * Extract Application Path from the Request URL
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setApplicationPath()
    {
        if (substr($this->request_path, -1) === '/') {
            $this->processRequestPath(0);
        }

        if (substr($this->request_path, 0, 1) === '/') {
            $this->processRequestPath(1);
        }

        if (strpos($this->request_path, '/') == true) {
            $application_test = substr($this->request_path, 0, strpos($this->request_path, '/'));
        } else {
            $application_test = $this->request_path;
        }

        return trim(strtolower($application_test));
    }

    /**
     * Process the Request Path
     *
     * @param   integer $start
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function processRequestPath($start)
    {
        $this->request_path = substr($this->request_path, $start, strlen($this->request_path) - 1);

        return $this;
    }

    /**
     * Get Application Array Entry
     *
     * @param   string $application_test
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function getApplicationArrayEntry($application_test)
    {
        $app = new stdClass();

        if (isset($this->applications[$application_test])) {
            $app = $this->applications[$application_test];

        } else {
            foreach ($this->applications as $key => $application) {
                if ((int)$application->default === 1) {
                    $app = $application;
                    break;
                }
            }
        }

        return $app;
    }

    /**
     * Set application base path
     *
     * @param   stdClass $app
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setApplicationBasePath($app)
    {
        if ($app->base_path === '') {
            $this->base_path = '';
            $this->path      = $this->request_path;
        } else {
            $this->base_path = $app->base_path;
            $this->path      = substr($this->request_path, strlen(trim($this->base_path)) + 1, 999);
        }

        if ($this->path === false) {
            $this->path = '';
        } elseif ($this->path === '/') {
            $this->path = '';
        }

        return $this;
    }
}
