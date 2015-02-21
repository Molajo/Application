<?php
/**
 * Application Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ApplicationInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\Controller\Application\Configuration;
use stdClass;

/**
 * Application Controller
 *
 * 1. Identifies Current Application
 * 2. Loads Application
 * 3. Defines Site Paths for Application
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Application extends Configuration implements ApplicationInterface
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

        $app              = $this->getApplicationArrayEntry($application_test);
        $this->id         = $app->id;
        $this->name       = $app->name;

        $this->setApplicationBasePath($app);

        return $this;
    }

    /**
     * Retrieve Application Data
     *
     * @return  stdClass
     * @since   1.0.0
     */
    public function getConfiguration()
    {
        $this->data = new stdClass();

        $this->getConfigurationInstallation();

        $data = $this->runConfigurationQuery();

        $this->data->id              = (int)$data->id;
        $this->data->base_path       = $this->base_path;
        $this->data->path            = $this->path;
        $this->data->name            = $data->name;
        $this->data->description     = $data->description;
        $this->data->catalog_id      = (int)$data->catalog_id;
        $this->data->catalog_type_id = (int)$data->catalog_type_id;

        $this->setCustomFields($data, $this->model_registry['customfieldgroups']);

        $this->getConfigurationLineEnd();

        return $this->data;
    }

    /**
     * Check if the Site has permission to utilise this Application
     *
     * @param   integer $site_id
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function verifySiteApplication($site_id)
    {
        $this->query->clearQuery();

        $this->query->select('site_id');
        $this->query->from('#__site_applications');
        $this->query->where('column', 'application_id', '=', 'integer', (int)$this->id);
        $this->query->where('column', 'site_id', '=', 'integer', (int)$site_id);

        $returned_site_id = $this->query->loadResult($this->query->getSQL());

        if ((int)$returned_site_id === (int)$site_id) {
            return $this;
        }

        throw new RuntimeException(
            'Application::verifySiteApplication Site: ' . $site_id . ' not authorised for Application: ' . $this->id
        );
    }
}
