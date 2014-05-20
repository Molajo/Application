<?php
/**
 * Text Controller
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller;

use CommonApi\Controller\TextInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Text Controller
 *
 * @package  Molajo
 * @license  http://www.opensource.org/licenses/mit-license.html MIT License
 * @since    1.0
 */
class TextController implements TextInterface
{
    /**
     * Set of words
     *
     * @var    array
     * @since  1.0
     */
    protected $lorem_set
        = array(
            'lorem',
            'ipsum',
            'dolor',
            'sit',
            'amet',
            'consectetur',
            'adipisicing',
            'elit',
            'sed',
            'do',
            'eiusmod',
            'tempor',
            'incididunt',
            'ut',
            'labore',
            'etdolore',
            'magna',
            'aliqua',
            'enim',
            'ad',
            'minim',
            'veniam',
            'quis',
            'nostrud',
            'exercitation',
            'ullamco',
            'laboris',
            'nisi',
            'aliquip',
            'ex',
            'ea',
            'commodo',
            'consequatduis',
            'aute',
            'irure',
            'in',
            'reprehenderit',
            'voluptate',
            'velit',
            'esse',
            'cillum',
            'dolore',
            'eu',
            'fugiat',
            'nulla',
            'pariatur',
            'excepteur',
            'sint',
            'occaecatcupidatat',
            'non',
            'proident',
            'sunt',
            'culpa',
            'qui',
            'officia',
            'deserunt',
            'mollit',
            'anim',
            'id',
            'est',
            'laborumcurabitur',
            'pretium',
            'tincidunt',
            'lacus',
            'gravida',
            'orci',
            'a',
            'odio',
            'nullam',
            'varius',
            'turpis',
            'etcommodo',
            'pharetra',
            'eros',
            'bibendum',
            'nec',
            'luctus',
            'felis',
            'sollicitudin',
            'mauris',
            'integerin',
            'nibh',
            'euismod',
            'duis',
            'ac',
            'tellus',
            'et',
            'risus',
            'vulputate',
            'vehicula',
            'donec',
            'lobortisrisus',
            'etiam',
            'ullamcorper',
            'ligula',
            'congue',
            'turpisid',
            'sapien',
            'quam',
            'maecenas',
            'fermentum',
            'consequat',
            'mi',
            'pellentesquemalesuada',
            'sem',
            'aliquet',
            'eget',
            'neque',
            'aliquam',
            'faucibuselit',
            'dictum',
            'nisl',
            'adipiscing',
            'malesuada',
            'diam',
            'erat',
            'cras',
            'mollisscelerisque',
            'nunc',
            'arcu',
            'curabitur',
            'php',
            'augue',
            'dapibus',
            'laoreet',
            'etpretium',
            'aenean',
            'mollis',
            'molestie',
            'feugiat',
            'hac',
            'habitasse',
            'platea',
            'dictumstfusce',
            'convallis',
            'imperdiet',
            'suscipit',
            'placeratipsum',
            'urna',
            'libero',
            'tristique',
            'sodalesmauris',
            'mattis',
            'semper',
            'leo',
            'dictumst',
            'vivamus',
            'facilisis',
            'at',
            'odiomauris',
            'elementum',
            'metus',
            'nonfeugiat',
            'vitae',
            'morbi',
            'maurisquisque',
            'proin',
            'scelerisque',
            'lobortisac',
            'eleifend',
            'diamsuspendisse',
            'suspendisse',
            'nonummy',
            'pulvinar',
            'laciniapede',
            'dignissim',
            'ornare',
            'praesent',
            'liguladapibus',
            'nam',
            'sam',
            'lobortisquam',
            'vestibulum',
            'massa',
            'lectus',
            'nullacras',
            'pellentesque',
            'habitant',
            'senectus',
            'netuset',
            'fames',
            'egestas',
            'lobortiselit',
            'dapibusaliquam',
            'pede',
            'purus',
            'consectetuerluctus',
            'nebraska',
            'feugiatpraesent',
            'hendrerit',
            'iaculis',
            'tellusa',
            'justo',
            'eratpraesent',
            'ligulaquis',
            'tortor',
            'posuere',
            'justonullam',
            'integer',
            'rutrum',
            'facilisiquisque',
            'vel',
            'egetsemper',
            'viverra',
            'quisque',
            'dolorduis',
            'volutpat',
            'condimentum',
            'lacusnunc',
            'orcietiam',
            'mialiquam',
            'porttitor',
            'variusenim',
            'lacinia',
            'gemma',
            'ultricies',
            'fusce',
            'porttitorhendrerit',
            'ante',
            'cursus',
            'tempus',
            'felissed',
            'rhoncus',
            'idlaoreet',
            'auctor',
            'sempernisi',
            'integersem',
            'fringilla',
            'praesentet',
            'pellentesqueleo',
            'venenatis',
            'interdum',
            'semut',
            'condimentumaenean',
            'accumsan',
            'porta',
            'egetaugue',
            'faucibus',
            'consectetuerquis',
            'ultrices',
            'nontristique',
            'netus',
            'molajo',
            'turpisegestas',
            'suscipitblandit',
            'sodales',
            'blandit',
            'massaarcu',
            'famesac',
            'ligulapraesent',
            'anteipsum',
            'primis',
            'cubilia',
            'curae',
            'ipsumdonec',
            'nuncfermentum',
            'consectetuer',
            'nullainteger',
            'sapiendonec',
            'commodomauris',
            'ametultrices',
            'proinlibero',
            'adipiscingnec'
        );

    /**
     * Constructor
     *
     * @param  array $lorem_set
     *
     * @since  1.0
     */
    public function __construct(
        array $lorem_set = array()
    ) {
        if (count($lorem_set) > 0) {
            $this->lorem_set = $lorem_set;
        }
    }

    /**
     * Generates Lorem Ipsum Placeholder Text
     *
     * Usage:
     *
     * $text->getPlaceHolderText(2, 3, 7, 'p', true);
     *  Generates 2 paragraphs, each with 3 lines of 7 random words each, each paragraph starting with 'Lorem ipsum'
     *
     * $text->getPlaceHolderText(1, 1, 3, 'h1', false);
     *  Generates 1 <h1> line using 3 random words
     *
     * $text->getPlaceHolderText(1, 10, 3, 'li', false);
     *  Generates 1 <ul> list with 10 items each with 3 random words
     *
     * @param   int     $number_of_paragraphs
     * @param   int     $lines_per_paragraphs
     * @param   int     $words_per_line
     * @param   string  $markup_type ('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
     * @param   bool    $start_with_lorem_ipsum
     * @param   array   $valid_markup
     *
     * @return  string
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getPlaceHolderText(
        $number_of_paragraphs = 3,
        $lines_per_paragraphs = 3,
        $words_per_line = 7,
        $markup_type = 'p',
        $start_with_lorem_ipsum = true,
        $valid_markup = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
    ) {
        $output = $this->createParagraphs(
            $this->editNumberOfParagraphs($number_of_paragraphs),
            $this->editLinesPerParagraph($lines_per_paragraphs),
            $this->editWordsPerLine($words_per_line),
            $this->editMarkupType($markup_type, $this->editValidMarkup()),
            $this->editStartWithLoremIpsum($start_with_lorem_ipsum),
            $this->editCountLoremSet()
        );

        if ($markup_type === 'ul' || $markup_type === 'ol') {
            $output .= '</' . $markup_type . '>';
        }

        return $output;
    }

    /**
     * Edit count lorem set
     *
     * @return  int
     * @since   1.0
     */
    protected function editCountLoremSet()
    {
        $count_lorem_set = count($this->lorem_set) - 1;
        if ($count_lorem_set < 10) {
            throw new RuntimeException(
                'Text Utility: getPlaceHolderText requires more than 10 lorem_set words.'
            );
        }
        return $count_lorem_set;
    }

    /**
     * Edit number of paragraphs
     *
     * @param   integer  $number_of_paragraphs
     *
     * @return  integer
     * @since   1.0
     */
    protected function editNumberOfParagraphs($number_of_paragraphs)
    {
        if ((int)$number_of_paragraphs === 0) {
            $number_of_paragraphs = 3;
        }

        return $number_of_paragraphs;
    }

    /**
     * Edit lines per paragraph
     *
     * @param   integer  $lines_per_paragraphs
     *
     * @return  integer
     * @since   1.0
     */
    protected function editLinesPerParagraph($lines_per_paragraphs)
    {
        if ((int)$lines_per_paragraphs === 0) {
            $lines_per_paragraphs = 3;
        }

        return $lines_per_paragraphs;
    }

    /**
     * Edit words per line
     *
     * @param   integer  $words_per_line
     *
     * @return  integer
     * @since   1.0
     */
    protected function editWordsPerLine($words_per_line)
    {
        if ((int)$words_per_line === 0) {
            $words_per_line = 7;
        }

        return $words_per_line;
    }

    /**
     * Edit Valid Markup
     *
     * @return  array
     * @since   1.0
     */
    protected function editValidMarkup()
    {
        $valid = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote');

        return $valid;
    }

    /**
     * Edit Markup Type
     *
     * @param   $markup_type
     * @param   $valid
     *
     * @return  string
     * @since   1.0
     */
    protected function editMarkupType($markup_type, $valid)
    {
        if (in_array($markup_type, $valid)) {
        } else {
            $markup_type = 'p';
        }

        return $markup_type;
    }

    /**
     * Edit Start with Lorem Ipsum
     *
     * @param   boolean $start_with_lorem_ipsum
     *
     * @return  boolean
     * @since   1.0
     */
    protected function editStartWithLoremIpsum($start_with_lorem_ipsum)
    {
        if ($start_with_lorem_ipsum === false) {
        } else {
            $start_with_lorem_ipsum = true;
        }

        return $start_with_lorem_ipsum;
    }

    /**
     * Create Paragraphs
     *
     * @param   integer $number_of_paragraphs
     * @param   integer $lines_per_paragraphs
     * @param   integer $words_per_line
     * @param   string  $markup_type
     * @param   boolean $start_with_lorem_ipsum
     * @param   integer $count_lorem_set
     *
     *
     * @return  string
     * @since   1.0.0
     */
    protected function createParagraphs(
        $number_of_paragraphs,
        $lines_per_paragraphs,
        $words_per_line,
        $markup_type,
        $start_with_lorem_ipsum,
        $count_lorem_set
    ) {
        list($output, $begin, $end) = $this->setMarkupRequirements($markup_type);

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
     * Establish the output pattern
     *
     * @param   string  $markup_type
     *
     * @return  array
     * @since   1.0
     */
    protected function setMarkupRequirements($markup_type)
    {
        if ($markup_type == 'ul' || $markup_type == 'ol') {
            $output = '<' . $markup_type . '>';
            $begin  = '<li>';
            $end    = '</li>';
        } else {
            $output = '';
            $begin  = '<' . $markup_type . '>';
            $end    = '</' . $markup_type . '>';
        }

        return array($output, $begin, $end);
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

            $word = $this->createWord($start_with_lorem_ipsum, $count_lorem_set, $word_count);

            $output .= ' ' . $word;

            if ($word_count < $words_per_line) {
            } else {
                $output .= $end;
            }
        }

        return $output;
    }

    /**
     * Create a single word
     *
     * @param  boolean  $start_with_lorem_ipsum
     * @param  integer  $count_lorem_set
     * @param  integer  $word_count
     *
     * @return string
     * @since  1.0.0
     */
    protected function createWord($start_with_lorem_ipsum, $count_lorem_set, $word_count)
    {
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

        return $word;
    }
}
