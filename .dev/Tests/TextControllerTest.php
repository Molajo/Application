<?php
/**
 * Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\TextController;

/**
 * Utilities Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class TextControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Utilities Connection
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetText()
    {
        $text_instance = new TextController();

        $test = $text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $words_per_paragraph = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true
        );

        $this->assertEquals(true, is_string($test));

        return $this;
    }
}
