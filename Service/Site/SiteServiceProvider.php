<?php
/**
 * Site Controller Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Site;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\ServiceProviderInterface;
use Molajo\IoC\AbstractServiceProvider;
use stdClass;

/**
 * Site Controller Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class SiteServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
{
    /**
     * Constructor
     *
     * @param   $options
     *
     * @since   1.0
     */
    public function __construct(array $options = array())
    {
        $options['service_namespace'] = 'Molajo\\Controller\\Site';
        $options['service_name']      = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Identify Class Dependencies for Constructor Injection
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies($reflection);
        /**
         * To make certain all dependencies are filled before Site runs and continues
         * scheduling from the Resources schedule
         */
        $options                           = array();
        $this->dependencies['Resource']    = $options;
        $this->dependencies['Request']     = $options;
        $this->dependencies['Runtimedata'] = $options;

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  void
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateService()
    {
        $host     = $this->dependencies['Request']->host;
        $base_url = $this->dependencies['Request']->base_url;
        $path     = $this->dependencies['Request']->path;

        $reference_data = $this->dependencies['Resource']->get('xml:///Molajo//Model//Application//Defines.xml');

        $sites = $this->sites();

        try {
            $class = $this->service_namespace;

            $this->service_instance = new $class(
                $host,
                $base_url,
                $path,
                $reference_data,
                $sites
            );
        } catch (Exception $e) {

            throw new RuntimeException
            ('IoC instantiateService Failed: ' . $this->service_namespace . '  ' . $e->getMessage());
        }

        return;
    }

    /**
     * Follows the completion of the instantiate service method
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInstantiation()
    {
        $this->service_instance->setBaseURL();

        $this->dependencies['Runtimedata']->reference_data = $this->service_instance->setReferenceData();
        $this->service_instance->identifySite();
        $this->dependencies['Runtimedata']->site = $this->sortObject($this->service_instance->get('*'));

        return $this;
    }

    /**
     * Service Provider Controller requests any Services (other than the current service) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setServices()
    {
        $this->set_services['Runtimedata'] = $this->dependencies['Runtimedata'];

        return $this->set_services;
    }

    /**
     * Installed Sites
     *
     * @return  $this
     * @since   1.0
     */
    public function sites()
    {
        $sitexml = $this->dependencies['Resource']->get('xml:///Molajo//Model//Application//Sites.xml');

        if (count($sitexml) > 0) {
        } else {
            return $this;
        }

        $sites = array();

        foreach ($sitexml as $item) {
            $site                   = new stdClass();
            $site->id               = (string)$item['id'];
            $site->name             = (string)$item['name'];
            $site->site_base_url    = (string)$item['base'];
            $site->site_base_folder = (string)$item['folder'];
            $sites[]                = $site;
        }

        return $sites;
    }
}
