<?php
/**
 * Site Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\Site;
use stdClass;

/**
 * Site Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * IoCC
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $queue;

    /**
     * Dispatcher
     *
     * @var    object  CommonApi\Event\DispatcherInterface
     * @since  1.0
     */
    protected $dispatcher;

    /**
     * Requests
     *
     * @var    array
     * @since  1.0
     */
    protected $requests;

    /**
     * Base Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path;

    /**
     * Front Controller Steps
     *
     * @var    array
     * @since  1.0
     */
    protected $steps
        = array(
            'initialise',
            'authenticate',
            'route',
            'authorise',
            'dispatcher',
            'execute',
            'response'
        );

    /**
     * @covers  Molajo\Controller\Site::__construct
     * @covers  Molajo\Controller\Site::get
     * @covers  Molajo\Controller\Site::getSiteProperties
     * @covers  Molajo\Controller\Site::setBase
     * @covers  Molajo\Controller\Site::identifySite
     * @covers  Molajo\Controller\Site::setSitePaths
     * @covers  Molajo\Controller\Site::installCheck
     *
     * @since   1.0.0
     */
    protected function setUp()
    {
        $host = 'site2';
        $path = 'admin';

        $sites                = array();
        $site                 = new stdClass();
        $site->id             = 1;
        $site->name           = 'Site 1';
        $site->site_base_url  = 'site1';
        $site->site_base_path = '1';
        $sites[]              = $site;

        $site                 = new stdClass();
        $site->id             = 2;
        $site->name           = 'Site 2';
        $site->site_base_url  = 'site2';
        $site->site_base_path = '2';
        $sites[]              = $site;

        $this->fc = new Site($host, $path, $sites);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Site::__construct
     * @covers  Molajo\Controller\Site::get
     * @covers  Molajo\Controller\Site::getSiteProperties
     * @covers  Molajo\Controller\Site::setBase
     * @covers  Molajo\Controller\Site::identifySite
     * @covers  Molajo\Controller\Site::setSitePaths
     * @covers  Molajo\Controller\Site::installCheck
     *
     * @since   1.0.0
     */
    public function testSetBase()
    {
        $this->fc->setBase('site2', 'admin');

        $this->assertEquals('site2', $this->fc->get('base_url'));
        $this->assertEquals('admin', $this->fc->get('base_path'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Site::__construct
     * @covers  Molajo\Controller\Site::get
     * @covers  Molajo\Controller\Site::getSiteProperties
     * @covers  Molajo\Controller\Site::setBase
     * @covers  Molajo\Controller\Site::identifySite
     * @covers  Molajo\Controller\Site::setSitePaths
     * @covers  Molajo\Controller\Site::installCheck
     *
     * @since   1.0.0
     */
    public function testGet()
    {
        $this->assertEquals('site2', $this->fc->get('host'));
        $this->assertEquals('admin', $this->fc->get('path'));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Site::__construct
     * @covers  Molajo\Controller\Site::get
     * @covers  Molajo\Controller\Site::getSiteProperties
     * @covers  Molajo\Controller\Site::setBase
     * @covers  Molajo\Controller\Site::identifySite
     * @covers  Molajo\Controller\Site::setSitePaths
     * @covers  Molajo\Controller\Site::installCheck
     *
     * @since   1.0.0
     */
    public function testSetSitePaths()
    {
        $this->fc->setBase('site2', 'admin');
        $this->fc->identifySite();

        $base = __DIR__;
        $this->assertEquals($base . '/Sites/2', $this->fc->get('site_base_path'));
        $this->assertEquals($base . '/Sites/Public/Media', $this->fc->get('sites_media_folder'));
        $this->assertEquals($base . '/Media', $this->fc->get('sites_media_url'));
        $this->assertEquals($base . '/Sites/Public/Media/', $this->fc->get('site_media_folder'));
        $this->assertEquals($base . 'Media/', $this->fc->get('site_base_path'));

        return $this;
    }
}
