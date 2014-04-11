<?php
/**
 * Site Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Site;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethodBase;
use stdClass;

/**
 * Site Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class SiteFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace'] = 'Molajo\\Controller\\Site';
        $options['product_name']      = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Identify Class Dependencies for Constructor Injection
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $host = $this->dependencies['Request']->host;
        $path = $this->dependencies['Request']->path;

        $sites = $this->sites();

        try {
            $class = $this->product_namespace;

            $this->product_result = new $class(
                $host,
                $path,
                $sites
            );
        } catch (Exception $e) {

            throw new RuntimeException
            ('IoC instantiateClass Failed: ' . $this->product_namespace . '  ' . $e->getMessage());
        }

        return;
    }

    /**
     * Follows the completion of the instantiate method
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInstantiation()
    {
        $this->dependencies['Runtimedata']->reference_data = $this->setReferenceData();

        $this->product_result->setBase(
            $this->dependencies['Request']->base_url,
            $this->options['base_path']
        );

        $this->product_result->identifySite();

        $this->dependencies['Runtimedata']->site = $this->sortObject($this->product_result->get('*'));

        return $this;
    }

    /**
     * Factory Method Controller requests any Products (other than the current product) to be saved
     *
     * @return  array
     * @since   1.0
     */
    public function setContainerEntries()
    {
        $this->set_container_entries['Runtimedata'] = $this->dependencies['Runtimedata'];

        return $this->set_container_entries;
    }

    /**
     * Installed Sites
     *
     * @return  $this
     * @since   1.0
     */
    protected function sites()
    {
        $sitexml = $this->dependencies['Resource']->get('xml:///Molajo//Model//Application//Sites.xml');

        if (count($sitexml) > 0) {
        } else {
            return $this;
        }

        $sites = array();

        foreach ($sitexml as $item) {
            $site                 = new stdClass();
            $site->id             = (string)$item['id'];
            $site->name           = (string)$item['name'];
            $site->site_base_url  = (string)$item['base'];
            $site->site_base_path = (string)$item['folder'];
            $sites[]              = $site;
        }

        return $sites;
    }

    /**
     * Custom set of reference data loaded for consistency in Application
     *
     * @return  $this
     * @since   1.0
     */
    protected function setReferenceData()
    {
        $defines = $this->dependencies['Resource']->get('xml:///Molajo//Model//Application//Defines.xml');

        $reference_data = new stdClass();

        if (count($defines) > 0) {
        } else {
            return $reference_data;
        }

        foreach ($defines->define as $item) {
            if (defined((string)$item['name'])) {
            } else {
                $value                         = (string)$item['value'];
                $reference_data->$item['name'] = $value;
            }
        }

        return $reference_data;
    }
}
