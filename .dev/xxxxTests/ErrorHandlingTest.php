<?php
/**
 * Error Handling Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\Errorhandling;

/**
 * Error Handling Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ErrorhandlingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Error Handling
     *
     * @var    object
     * @since  1.0.0
     */
    protected $error_handling;

    /**
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->error_handling = new Errorhandling();
    }

    /**
     * 403
     *
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet403Error()
    {
        $results = $this->error_handling->setError($error_code = 403);

        $this->assertEquals(403, $results->error_code);
        $this->assertEquals('Not Authorised', $results->error_message);
        $this->assertEquals('Molajo\\Themes\\System', $results->theme_namespace);
        $this->assertEquals('Molajo\\Views\\Pages\\Error', $results->page_namespace);

        return $this;
    }

    /**
     * 404
     *
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet404Error()
    {
        $results = $this->error_handling->setError($error_code = 404);

        $this->assertEquals(404, $results->error_code);
        $this->assertEquals('Not Found', $results->error_message);
        $this->assertEquals('Molajo\\Themes\\System', $results->theme_namespace);
        $this->assertEquals('Molajo\\Views\\Pages\\Error', $results->page_namespace);

        return $this;
    }

    /**
     * 500
     *
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet500Error()
    {
        $results = $this->error_handling->setError($error_code = 500);

        $this->assertEquals(500, $results->error_code);
        $this->assertEquals('Internal Server Error', $results->error_message);
        $this->assertEquals('Molajo\\Themes\\System', $results->theme_namespace);
        $this->assertEquals('Molajo\\Views\\Pages\\Error', $results->page_namespace);

        return $this;
    }

    /**
     * 503
     *
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet503Error()
    {
        $results = $this->error_handling->setError($error_code = 503);

        $this->assertEquals(503, $results->error_code);
        $this->assertEquals('Site is Offline.', $results->error_message);
        $this->assertEquals('Molajo\\Themes\\System', $results->theme_namespace);
        $this->assertEquals('Molajo\\Views\\Pages\\Offline', $results->page_namespace);

        return $this;
    }

    /**
     * 503
     *
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetMessageError()
    {
        $results = $this->error_handling->setError($error_code = 500, 'This is my own message');

        $this->assertEquals(500, $results->error_code);
        $this->assertEquals('This is my own message', $results->error_message);
        $this->assertEquals('Molajo\\Themes\\System', $results->theme_namespace);
        $this->assertEquals('Molajo\\Views\\Pages\\Error', $results->page_namespace);

        return $this;
    }

    /**
     * Invalid Code
     *
     * @covers  Molajo\Controller\Errorhandling::__construct
     * @covers  Molajo\Controller\Errorhandling::setError
     * @covers  Molajo\Controller\Errorhandling::setErrorMessage
     * @covers  Molajo\Controller\Errorhandling::setThemePageView
     *
     * @expectedException \CommonApi\Exception\ErrorThrownAsException
     * @expectedExceptionMessage
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetInvalidError()
    {
        $results = $this->error_handling->setError($error_code = 0);

        $this->assertEquals(0, $results->error_code);
        $this->assertEquals('Internal Server Error', $results->error_message);
        $this->assertEquals('Molajo\\Themes\\System', $results->theme_namespace);
        $this->assertEquals('Molajo\\Views\\Pages\\Error', $results->page_namespace);

        return $this;
    }
}
