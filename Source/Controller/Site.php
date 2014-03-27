<?php
/**
 * Site Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use stdClass;
use CommonApi\Controller\SiteInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Site Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Site implements SiteInterface
{
    /**
     * Data identifying sites for this implementation
     *
     * @var    object
     * @since  1.0
     */
    protected $sites = null;

    /**
     * Host
     *
     * @var    string
     * @since  1.0
     */
    protected $host = null;

    /**
     * Site ID
     *
     * @var    string
     * @since  1.0
     */
    protected $id = null;

    /**
     * Site Name
     *
     * @var    string
     * @since  1.0
     */
    protected $name = null;

    /**
     * Site Base URL
     *
     * @var    string
     * @since  1.0
     */
    protected $base_url = null;

    /**
     * Site Base Path
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path = null;

    /**
     * Site Base Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $site_base_path = null;

    /**
     * Site Media Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $site_media_folder = null;

    /**
     * Site Media URL
     *
     * @var    string
     * @since  1.0
     */
    protected $site_media_url = null;

    /**
     * Sites Media Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $sites_media_folder = null;

    /**
     * Sites Media URL
     *
     * @var    string
     * @since  1.0
     */
    protected $sites_media_url = null;

    /**
     * List of Properties
     *
     * @var    object
     * @since  1.0
     */
    protected $property_array = array(
        'id',
        'name',
        'base_url',
        'base_path',
        'site_base_path',
        'site_media_folder',
        'site_media_url',
        'sites_media_folder',
        'sites_media_url'
    );

    /**
     * Constructor
     *
     * @param  string $host
     * @param  string $path
     * @param  array  $sites
     *
     * @since  1.0
     */
    public function __construct(
        $host,
        $path,
        $sites
    ) {
        $this->host  = $host;
        $this->path  = $path;
        $this->sites = $sites;
    }

    /**
     * Get the current value (or default) of the specified key
     *
     * @param   string $key
     * @param   mixed  $default
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($key = null, $default = null)
    {
        if ($key == '*') {
            $site = new stdClass();
            foreach ($this->property_array as $key) {
                $site->$key = $this->$key;
            }
            return $site;
        }

        $key = strtolower($key);

        if (in_array($key, $this->property_array)) {
        } else {
            throw new RuntimeException
            ('Site Service: attempting to get value for unknown property: ' . $key);
        }

        if ($this->$key === null) {
            $this->$key = $default;
        }

        return $this->$key;
    }

    /**
     * Define Site URL and Folder using scheme, host, and base URL
     *
     * @param   string $base_url
     * @param   string $base_path
     *
     * @return  $this
     * @since   1.0
     */
    public function setBase($base_url, $base_path)
    {
        $this->base_url  = $base_url;
        $this->base_path = $base_path;

        return $this;
    }

    /**
     * Identifies the specific site and sets site paths for use in the application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function identifySite()
    {
        foreach ($this->sites as $single) {

            if (strtolower((string)$single->site_base_url) == strtolower($this->host)) {

                $this->id             = $single->id;
                $this->name           = $single->name;
                $this->site_base_path = $this->base_path . $single->site_base_path;

                if (substr($this->path, 0, strlen('installation')) == 'installation') {
                } else {
                    $this->installCheck();
                }

                break;
            }
        }

        if ($this->base_path === null) {
            throw new RuntimeException
            ('Sites Service: Cannot identify site for: ' . $this->base_url);
        }

        $this->site_base_path     = $this->base_path . '/Sites/' . $this->id;
        $this->sites_media_folder = $this->base_path . '/Sites/Public/Media';
        $this->sites_media_url    = $this->base_url . '/Media';
        $this->site_media_folder  = $this->base_path . '/Sites/Public/Media/' . $this->id;
        $this->site_media_url     = $this->base_url . '/Media/' . $this->id;

        return $this;
    }

    /**
     * Determine if the site has already been installed
     *
     * return  $this
     *
     * @since  1.0
     */
    public function installCheck()
    {
        if (defined('SKIP_INSTALL_CHECK')) {
            return $this;
        }

        if (file_exists($this->site_base_path . '/Temp/Index.html')) {
            return $this;
        }

        $redirect = $this->host . 'installation/';
        header('Location: ' . $redirect);
        exit();
    }

    /**
     * Check if the Site has permission to utilise this Application
     *
     * @param   int $site_id
     *
     * @return  $this
     * @since   1.0
     */
    public function verifySiteApplication($site_id)
    {
        $query = $this->database->getQueryObject();

        $query->select('id');
        $query->from('#__site_applications');
        $query->where(
            'application_id'
            . ' = '
            . $this->id
        );
        $query->where(
            'site_id'
            . ' = '
            . $site_id
        );

        $valid = $this->database->loadResult($query->getSQL());

        if ($valid === false) {
        } else {
            return $this;
        }

        die('Site accessing invalid application.');
    }
}
