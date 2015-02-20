<?php
/**
 * Url Controller
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller;

use Exception;
use CommonApi\Controller\UrlInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Url Controller
 *
 * @package     Molajo
 * @subpackage  Service
 * @since       1.0
 */
class UrlController implements UrlInterface
{
    /**
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Base Path
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path;

    /**
     * Site Base URL
     *
     * @var    string
     * @since  1.0
     */
    protected $site_base_url;

    /**
     * Application ID
     *
     * @var    int
     * @since  1.0
     */
    protected $application_id;

    /**
     * Application Base
     *
     * @var    int
     * @since  1.0
     */
    protected $application_base;

    /**
     * Home Catalog ID
     *
     * @var    int
     * @since  1.0
     */
    protected $home_catalog_id;

    /**
     * Url SEF Option
     *
     * @var    boolean
     * @since  1.0
     */
    protected $url_sef = 1;

    /**
     * Constructor
     *
     * @param  object $resource
     * @param  string $site_base_url
     * @param  int    $application_id
     * @param  string $application_base
     * @param  int    $home_catalog_id
     * @param  int    $url_sef
     *
     * @since  1.0
     */
    public function __construct(
        $resource,
        $site_base_url,
        $application_id,
        $application_base,
        $home_catalog_id,
        $url_sef
    ) {
        $this->resource         = $resource;
        $this->site_base_url    = $site_base_url;
        $this->application_id   = $application_id;
        $this->application_base = $application_base;
        $this->home_catalog_id  = $home_catalog_id;
        $this->url_sef          = $url_sef;
    }

    /**
     * Retrieves Catalog ID for the specified Catalog Type ID and Source ID
     *
     * @param   int      $request_type
     * @param   null|int $catalog_type_id
     * @param   null|int $source_id
     * @param   null|int $url_sef_request
     *
     * @return  mixed
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($request_type = 1, $catalog_type_id = null, $source_id = null, $url_sef_request = null)
    {
        $query = $this->resource->get('query:///Molajo/Datasource/Catalog');

        $query->setModelRegistry('check_view_level_access', 0);
        $query->setModelRegistry('process_events', 0);
        $query->setModelRegistry('get_item_children', 0);
        $query->setModelRegistry('use_special_joins', 1);

        $prefix = $query->getModelRegistry('primary_prefix');
        $key    = $query->getModelRegistry('primary_key');

        /** Get Catalog ID */
        if ($request_type === 1) {
            $query->setModelRegistry('query_object', 'result');

            $query->query->select(
                $prefix
                . '.'
                . $key
            );

            /** Get Redirect ID */
        } elseif ($request_type === 2) {
            $query->setModelRegistry('query_object', 'result');

            $query->query->select(
                $prefix
                . '.'
                . 'redirect_id'
            );

            /** Get SEF Request */
        } elseif ($request_type === 3) {
            $query->setModelRegistry('query_object', 'result');

            $query->query->select(
                $prefix
                . '.'
                . 'sef_request'
            );

            /** All Catalog Elements */
        } else {
            $query->setModelRegistry('query_object', 'item');
        }

        /** Criteria: Catalog Type ID and Source ID */
        if ($url_sef_request === null) {
            $query->query->where(
                $prefix
                . '.' . 'catalog_type_id'
                . ' = '
                . (int)$catalog_type_id
            );

            $query->query->where(
                $prefix
                . '.'
                . 'source_id'
                . ' = '
                . (int)$source_id
            );
        } else {

            /** Criteria: SEF Request */
            $query->query->where(
                $prefix
                . '.'
                . 'sef_request'
                . ' = '
                . $url_sef_request
            );
        }

        $query->query->where(
            $prefix
            . '.'
            . 'application_id'
            . ' = '
            . $this->application_id
        );

        $query->query->setSql();

        try {
            $results = $query->getData();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $results;
    }

    /**
     * Add a Trailing Slash
     *
     * @param   string $url
     *
     * @return  string
     * @since   1.0.0
     */
    public function addTrailingSlash($url)
    {
        return $this->removeTrailingSlash($url) . '/';
    }

    /**
     * Remove the Trailing Slash
     *
     * @param   string $url
     *
     * @return  string
     * @since   1.0.0
     */
    public function removeTrailingSlash($url)
    {
        return rtrim($url, '/');
    }

    /**
     * Add Site URL and application path to URL path
     *
     * @param   string $path
     *
     * @return  string
     * @since   1.0.0
     */
    public function getApplicationURL($path = '')
    {
        return $this->site_base_url . $this->application_base . $path;
    }

    /**
     * checkURLExternal - determines if it is a local site or external link
     *
     * @param   string $url
     *
     * @return  boolean
     * @since   1.0.0
     */
    public function checkURLExternal($url)
    {
        if (substr($url, 0, strlen($this->site_base_url)) === $this->site_base_url) {
            return false;

        } elseif ((strtolower(substr($url, 0, 3)) === 'www')
            && (substr($url, 3, strlen($this->site_base_url)) === $this->site_base_url)
        ) {
            return false;
        }

        return true;
    }

    /**
     * urlShortener
     *
     * @param  string $url
     * @param  int    $type
     *
     * 1 TinyURL
     * 2 is.gd
     * 3 Local
     *
     * @return  string
     * @since   1.0.0
     */
    public function urlShortener($url, $type = 2)
    {
        if ($type === '1') {
            return (implode('', file('http://tinyurl.com/api-create.php?url=' . urlencode($url))));
        } elseif ($type === '2') {
            return (implode('', file('http://is.gd/api.php?longurl=' . urlencode($url))));
        }

        return $url;
    }
}
