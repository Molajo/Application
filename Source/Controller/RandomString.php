<?php
/**
 * Random String Controller
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller;

use CommonApi\Controller\RandomStringInterface;

/**
 * Random String Controller
 *
 * @package     Molajo
 * @copyright   2014 Amy Stephen. All rights reserved.
 * @license     http://www.opensource.org/licenses/mit-license.html MIT License
 * @since       1.0
 */
class RandomString implements RandomStringInterface
{
    /**
     * Length of String
     *
     * @var    string
     * @since  1.0
     */
    protected $length;

    /**
     * Length of String
     *
     * @var    string
     * @since  1.0
     */
    protected $characters;

    /**
     * Constructor
     *
     * @param  int $length
     *
     * @since  1.0
     */
    public function __construct(
        $length = 15,
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        if ((int)$length < 5) {
        } else {
            $this->length = (int)$length;
        }

        if ($characters === null || trim($characters) === '') {
        } else {
            $this->characters = $characters;
        }
    }

    /**
     * Generate a Random String of an optional specified length
     *
     * @param   null|int    $length
     * @param   null|string $characters
     *
     * @return  string
     * @since   1.0
     */
    public function generateString($length = null, $characters = null)
    {
        if ((int)$length < 5) {
        } else {
            $this->length = (int)$length;
        }

        if ($characters === null) {
        } else {
            $this->characters = $characters;
        }

        $random_string = '';

        for ($i = 0; $i < $this->length; $i ++) {
            $random_string .= $this->characters[rand(0, strlen($this->characters) - 1)];
        }

        return $random_string;
    }
}
