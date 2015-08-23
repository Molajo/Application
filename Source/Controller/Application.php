<?php
/**
 * Application Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Application\ApplicationInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\Controller\Application\Set;
use stdClass;

/**
 * Application Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
final class Application extends Set implements ApplicationInterface
{
    /**
     * Using Request URI, identify current application and page request
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setApplication()
    {
        $application_test = $this->setApplicationPath();

        $app        = $this->getApplicationArrayEntry($application_test);
        $this->id   = $app->id;
        $this->name = $app->name;

        $this->setApplicationBasePath($app);

        return $this;
    }

    /**
     * Verify Site permission fpr Application
     *
     * @param   integer $site_id
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function verifySiteApplication($site_id)
    {
        $this->site_id = $site_id;

        $this->setQueryController('Molajo//Model//Datasource//Siteapplications.xml');

        $this->setQueryControllerDefaults(
            $process_events = 0,
            $query_object = 'result',
            $get_customfields = 0,
            $use_special_joins = 0,
            $use_pagination = 0,
            $check_view_level_access = 0,
            $get_item_children = 0
        );

        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->query->select($prefix . '.' . 'site_id');
        $this->query->where('column', $prefix . '.' . 'application_id', '=', 'integer', (int)$this->id);
        $this->query->where('column', $prefix . '.' . 'site_id', '=', 'integer', (int)$this->site_id);

        $returned_site_id = $this->runQuery();

        if ((int)$returned_site_id === (int)$this->site_id) {
            return $this;
        }

        throw new RuntimeException('Site: ' . $this->site_id . ' not authorised for Application: ' . $this->id);
    }

    /**
     * Retrieve Application Data
     *
     * @return  stdClass
     * @since   1.0.0
     */
    public function getConfiguration()
    {
        if ($this->name === 'installation') {
            return $this->getConfigurationInstallation();
        }

        $this->setQueryController('Molajo//Model//Datasource//Application.xml');

        $this->setQueryControllerDefaults(
            $process_events = 0,
            $query_object = 'item',
            $get_customfields = 0,
            $use_special_joins = 1,
            $use_pagination = 0,
            $check_view_level_access = 0,
            $get_item_children = 0
        );

        $this->query->where('column', 'a.name', '=', 'string', $this->name);

        $data = $this->runQuery();

        $model_registry = $this->setModelRegistry();
        $application    = $this->setStandardFields($data, $model_registry);
        $application    = $this->setCustomFields($application, $data, $model_registry);
        $application    = $this->getConfigurationLineEnd($application);

        $application->application_base_path = $this->application_base_path;
        $application->path                  = $this->path;

        return $application;
    }

    /**
     * Installation Application, only
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getConfigurationInstallation()
    {
        $data              = new stdClass();
        $data->id          = 0;
        $data->name        = $this->name;
        $data->description = $this->name;

        return $data;
    }

    /**
     * Get Configuration Line End and HTML 5 data
     *
     * @param   object $data
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function getConfigurationLineEnd($data)
    {
        if (isset($data->parameters->application_html5)
            && $data->parameters->application_html5 === 1
        ) {
            $data->parameters->application_line_end = '>' . chr(10);
        } else {
            $data->parameters->application_html5    = 0;
            $data->parameters->application_line_end = '/>' . chr(10);
        }

        return $data;
    }
}
