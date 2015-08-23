<?php
/**
 * Fieldhandler Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Model;

use CommonApi\Fieldhandler\FieldhandlerInterface;

class AppFieldhandlerMock implements FieldhandlerInterface
{
    public function validate($field_name, $field_value = null, $constraint, array $options = array())
    {

    }

    public function sanitize($field_name, $field_value = null, $constraint, array $options = array())
    {
        return new AppItem($field_value);
    }

    public function format($field_name, $field_value = null, $constraint, array $options = array())
    {

    }
}

/**
 * Fieldhandler Item Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
class AppItem
{
    /**
     * Value
     *
     * @var    string
     * @since  1.0
     */
    protected $value = null;

    /**
     * Constructor
     *
     * @param mixed $value
     *
     * @since  1.0
     */
    public function __construct(
        $value
    ) {
        $this->value = $value;
    }

    public function getFieldValue()
    {
        return $this->value;
    }
}
