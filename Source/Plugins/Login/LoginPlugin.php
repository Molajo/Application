<?php
/**
 * Login Plugin
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Plugins\Login;

use Molajo\Plugins\AuthenticateEventPlugin;
use CommonApi\Event\AuthenticateInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Login Plugin
 *
 * @package     Molajo
 * @license     http://www.opensource.org/licenses/mit-license.html MIT License
 * @since       1.0
 */
class LoginPlugin extends AuthenticateEventPlugin implements AuthenticateInterface
{
    /**
     * Before Authenticating the Login Process
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeAuthenticate()
    {
        return $this;
    }

    /**
     * After Authenticating the Login Process
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onAfterAuthenticate()
    {
        return $this;
    }
}
