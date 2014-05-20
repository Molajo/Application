<?php
/**
 * Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Controller\TextInterface;
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
     * Text Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $text_instance;

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->text_instance = new MockTextController();
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetText()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals(true, is_string($results));

        return $this;
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditCountLoremSet()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals(262, $this->text_instance->count_lorem_set);
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditNumberOfParagraphs()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals($number_of_paragraphs, $this->text_instance->number_of_paragraphs);
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditLinesPerParagraph()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals(3, $this->text_instance->lines_per_paragraphs);
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditWordsPerLine()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals(7, $this->text_instance->words_per_line);
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditValidMarkup()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals(array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote'),
            $this->text_instance->valid);
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditMarkupType()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals('p', $this->text_instance->markup_type);
    }

    /**
     * @covers Molajo\Controller\TextController::getPlaceHolderText
     * @covers Molajo\Controller\TextController::editCountLoremSet
     * @covers Molajo\Controller\TextController::editNumberOfParagraphs
     * @covers Molajo\Controller\TextController::editLinesPerParagraph
     * @covers Molajo\Controller\TextController::editWordsPerLine
     * @covers Molajo\Controller\TextController::editValidMarkup
     * @covers Molajo\Controller\TextController::editMarkupType
     * @covers Molajo\Controller\TextController::editStartWithLoremIpsum
     * @covers Molajo\Controller\TextController::createParagraphs
     * @covers Molajo\Controller\TextController::setMarkupRequirements
     * @covers Molajo\Controller\TextController::createLines
     * @covers Molajo\Controller\TextController::createWords
     *
     * @return  $this
     * @since   1.0
     */
    public function testEditStartWithLoremIpsum()
    {
        $results = $this->text_instance->getPlaceHolderText(
            $number_of_paragraphs = 3,
            $lines_per_paragraphs = 3,
            $words_per_line = 7,
            $markup_type = 'p',
            $start_with_lorem_ipsum = true,
            $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
        );

        $this->assertEquals(true, $this->text_instance->start_with_lorem_ipsum);
    }
}


class MockTextController extends TextController implements TextInterface
{
    public $count_lorem_set;
    public $number_of_paragraphs;
    public $lines_per_paragraphs;
    public $words_per_line;
    public $editWordsPerLine;
    public $valid;
    public $markup_type;
    public $start_with_lorem_ipsum;

    public function getPlaceHolderText(
        $number_of_paragraphs = 3,
        $lines_per_paragraphs = 3,
        $words_per_line = 7,
        $markup_type = 'p',
        $start_with_lorem_ipsum = true,
        $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
    ) {
        $output = parent::getPlaceHolderText($number_of_paragraphs,
            $lines_per_paragraphs,
            $words_per_line,
            $markup_type,
            $start_with_lorem_ipsum,
            $valid_markup
        );

        return $output;
    }

    protected function editCountLoremSet()
    {
        $this->count_lorem_set = parent::editCountLoremSet();

        return $this->count_lorem_set;
    }

    protected function editNumberOfParagraphs($number_of_paragraphs)
    {
        $this->number_of_paragraphs = parent::editNumberOfParagraphs($number_of_paragraphs);

        return $this->number_of_paragraphs;
    }

    protected function editLinesPerParagraph($lines_per_paragraphs)
    {
        $this->lines_per_paragraphs = parent::editNumberOfParagraphs($lines_per_paragraphs);

        return $this->lines_per_paragraphs;
    }

    protected function editWordsPerLine($words_per_line)
    {
        $this->words_per_line = parent::editNumberOfParagraphs($words_per_line);

        return $this->words_per_line;
    }

    protected function editValidMarkup()
    {
        $this->valid = parent::editValidMarkup();

        return $this->valid;
    }

    protected function editMarkupType($markup_type, $valid)
    {
        $this->markup_type = parent::editMarkupType($markup_type, $valid);

        return $this->markup_type;
    }

    protected function editStartWithLoremIpsum($start_with_lorem_ipsum)
    {
        $this->start_with_lorem_ipsum = parent::editStartWithLoremIpsum($start_with_lorem_ipsum);

        return $this->start_with_lorem_ipsum;
    }

    protected function createParagraphs(
        $number_of_paragraphs,
        $lines_per_paragraphs,
        $words_per_line,
        $markup_type,
        $start_with_lorem_ipsum,
        $count_lorem_set
    ) {
        if ($markup_type == 'ul' || $markup_type == 'ol') {
            $output = '<' . $markup_type . '>';
            $begin  = '<li>';
            $end    = '</li>';
        } else {
            $output = '';
            $begin  = '<' . $markup_type . '>';
            $end    = '</' . $markup_type . '>';
        }

        for ($paragraph_count = 0; $paragraph_count < $number_of_paragraphs; $paragraph_count++) {

            $output .= $begin;

            $output = $this->createLines(
                $lines_per_paragraphs,
                $words_per_line,
                $start_with_lorem_ipsum,
                $output,
                $count_lorem_set,
                $end
            );

            $output .= $end;
        }

        return $output;
    }

    /**
     * Create Lines
     *
     * @param   integer $lines_per_paragraphs
     * @param   integer $words_per_line
     * @param   boolean $start_with_lorem_ipsum
     * @param   string  $output
     * @param   integer $count_lorem_set
     * @param   string  $end
     *
     * @return  string
     * @since   1.0.0
     */
    protected function createLines(
        $lines_per_paragraphs,
        $words_per_line,
        $start_with_lorem_ipsum,
        $output,
        $count_lorem_set,
        $end
    ) {
        for ($line_count = 0; $line_count < $lines_per_paragraphs; $line_count++) {

            $output = $this->createWords($words_per_line, $start_with_lorem_ipsum, $output, $count_lorem_set, $end);

            $output .= '.';
        }

        return $output;
    }

    /**
     * Create Words
     *
     * @param  integer $words_per_line
     * @param  boolean $start_with_lorem_ipsum
     * @param  string  $output
     * @param  integer $count_lorem_set
     * @param  string  $end
     *
     * @return string
     * @since  1.0.0
     */
    protected function createWords($words_per_line, $start_with_lorem_ipsum, $output, $count_lorem_set, $end)
    {
        for ($word_count = 0; $word_count < $words_per_line; $word_count++) {

            if ($word_count === 0 && $start_with_lorem_ipsum === true) {
                $word = 'Lorem';
            } elseif ($word_count === 1 && $start_with_lorem_ipsum === true) {
                $word = 'ipsum';
            } else {
                $word = $this->lorem_set[rand(0, $count_lorem_set)];
            }

            if ($word_count === 0) {
                $word = ucfirst(strtolower($word));
            }

            $output .= ' ' . $word;

            if ($word_count < $words_per_line) {
            } else {
                $output .= $end;
            }
        }

        return $output;
    }
}
