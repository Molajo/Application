<?php
/**
 * Error Handling Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use stdClass;
use CommonApi\Controller\ErrorHandlingInterface;
use CommonApi\Exception\ErrorThrownAsException;

/**
 * Error Handling Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ErrorHandling implements ErrorHandlingInterface
{
    /**
     * Not Authorised Message
     *
     * @var    string
     * @since  1.0
     */
    protected $error_message_not_authorised = 'Not Authorised';

    /**
     * Not Found Message
     *
     * @var    string
     * @since  1.0
     */
    protected $error_message_not_found = 'Not Found';

    /**
     * Internal Server Error Message
     *
     * @var    string
     * @since  1.0
     */
    protected $error_message_internal_server_error = 'Internal Server Error';

    /**
     * Site is Offline Error Message
     *
     * @var    string
     * @since  1.0
     */
    protected $error_message_offline_switch = 'Site is Offline.';

    /**
     * Error Theme Namespace
     *
     * @var    string
     * @since  1.0
     */
    protected $error_theme = 'Molajo\\Themes\\System';

    /**
     * Page View for Offline Error
     *
     * @var    string
     * @since  1.0
     */
    protected $error_page_offline_view = 'Molajo\\Views\\Pages\\Offline';

    /**
     * Page View for Standard Error
     *
     * @var    string
     * @since  1.0
     */
    protected $error_page_view = 'Molajo\\Views\\Pages\\Error';

    /**
     * Class Constructor
     *
     * @param  string $error_theme
     * @param  string $error_page_view
     * @param  string $error_message_not_authorised
     * @param  string $error_message_not_found
     * @param  string $error_message_internal_server_error
     * @param  string $error_offline_theme
     * @param  string $error_page_offline_view
     * @param  string $error_message_offline_switch
     *
     * @since  1.0
     */
    public function __construct(
        $error_theme = 'Molajo\\Themes\\System',
        $error_page_view = 'Molajo\\Views\\Pages\\Error',
        $error_message_not_authorised = 'Not Authorised',
        $error_message_not_found = 'Not Found',
        $error_message_internal_server_error = 'Internal Server Error',
        $error_offline_theme = 'Molajo\\Themes\\System',
        $error_page_offline_view = 'Molajo\\Views\\Pages\\Offline',
        $error_message_offline_switch = 'This site is not available.\<\br /\>\ Please check back again soon.'
    ) {
        set_error_handler(array($this, 'setError'), 0);
    }

    /**
     * Set 403, 404, 500 and 503 Error. Throw exception for any other errors.
     * Set rendering parameters for theme, page and template.
     *
     * @param   int    $error_code
     * @param   string $error_message
     * @param   string $file
     * @param   string $line
     *
     * @return  object|stdClass
     * @throws  \CommonApi\Exception\ErrorThrownAsException
     * @since   1.0
     */
    public function setError($error_code = 0, $error_message = '', $file = '', $line = '')
    {
        $error_object             = new stdClass();
        $error_object->error_code = $error_code;
        if ($error_message === '') {
            $error_object->error_message = $this->setErrorMessage($error_code);
        } else {
            $error_object->error_message = $error_message;
        }
        $error_object->file = $file;
        $error_object->line = $line;

        $error_object = $this->setThemePageView($error_code, $error_object);

        return $error_object;
    }

    /**
     * Set Error Message
     *
     * @param   integer $error_code
     *
     * @returns string
     * @since   1.0.0
     * @throws  \CommonApi\Exception\ErrorThrownAsException
     */
    protected function setErrorMessage($error_code)
    {
        if ($error_code == 403) {
            $error_message = $this->error_message_not_authorised;

        } elseif ($error_code == 404) {
            $error_message = $this->error_message_not_found;

        } elseif ($error_code == 500) {
            $error_message = $this->error_message_internal_server_error;

        } elseif ($error_code == 503) {
            $error_message = $this->error_message_offline_switch;

        } else {
            throw new ErrorThrownAsException($this->error_message_internal_server_error);
        }

        return $error_message;
    }

    /**
     * Set Theme and Page View
     *
     * @param   integer $error_code
     * @param   object  $error_object
     *
     * @returns object
     * @since   1.0.0
     */
    protected function setThemePageView($error_code, $error_object)
    {
        if ($error_code == 503) {
            $error_object->theme_namespace = $this->error_theme;
            $error_object->page_namespace  = $this->error_page_offline_view;
        } else {
            $error_object->theme_namespace = $this->error_theme;
            $error_object->page_namespace  = $this->error_page_view;
        }

        return $error_object;
    }
}
