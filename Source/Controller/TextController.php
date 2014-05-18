<?php
/**
 * Text Controller
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller;

use stdClass;
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
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resource = null;

    /**
     * Set of words
     *
     * @var    array
     * @since  1.0
     */
    protected $lorem_set = array(
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
     * @param  object $resource
     * @param  array  $lorem_set
     *
     * @since  1.0
     */
    public function __construct(
        $resource = null,
        array $lorem_set = array()
    ) {
        $this->resource = $resource;
        if (count($lorem_set) > 0) {
            $this->lorem_set = $lorem_set;
        }
    }

    /**
     * getDatalist creates named pair lists
     *
     * @param   string $model_type
     * @param   string $model_name
     * @param   int    $multiple
     * @param   int    $size
     * @param   int    $catalog_type_id
     * @param   int    $extension_instance_id
     * @param   array  $fields
     * @param   array  $values
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getDatalist(
        $model_type = 'Datalist',
        $model_name,
        $multiple = 0,
        $size = 5,
        $catalog_type_id = 0,
        $extension_instance_id = 0,
        array $fields = array(),
        array $values = array()
    ) {
        if (is_array($values) && count($values) === 0) {

            $query_results = array();

            $temp_row = new stdClass();

            $temp_row->listitems = $values;
            $temp_row->multiple  = $multiple;
            $temp_row->size      = $size;
            $query_results[]     = $temp_row;

            return $query_results;
        }

        $query = $this->resource->get('query:///' . $model_type . '//' . $model_name);

        $query->setModelRegistry('check_view_level_access', 0);
        $query->setModelRegistry('process_events', 1);
        $query->setModelRegistry('query_object', 'distinct');
        $query->setModelRegistry('get_item_children', 0);
        $query->setModelRegistry('model_offset', 0);
        $query->setModelRegistry('model_count', 9999);

        $primary_prefix = $query->get('primary_prefix', 'a');
        $primary_key    = $query->get('primary_key', 'id');
        $name_key       = $query->get('name_key', '', 'data_registry');

        $first = true;
        if (count($fields) < 2) {
            $query->setDistinct(true);
            $query->select($primary_prefix . '.' . $primary_key, 'id');
            $query->select($primary_prefix . '.' . $name_key, 'value');
            $query->orderBy($primary_prefix . '.' . $name_key, 'ASC');
        } else {

            $ordering = '';

            foreach ($fields as $field) {

                if (isset($field['alias'])) {
                    $prefix = $field['alias'];
                } else {
                    $prefix = $primary_prefix;
                }

                $name = $field['name'];

                if ($first) {
                    $first    = false;
                    $as       = 'id';
                    $distinct = 'distinct';
                } else {
                    $as       = 'value';
                    $distinct = '';
                    $ordering = $prefix . '.' . $name;
                }

                if (trim($distinct) == 'distinct') {
                    $query->setDistinct(true);
                }
                $query->select($primary_prefix . '.' . $primary_key, 'id');
                $query->select($prefix . '.' . $name, $as);
            }

            $query->orderBy($ordering, 'ASC');
        }

        if ($query->get('extension_instance_id', 0) == 0) {
        } else {
            $this->whereCriteria(
                'column',
                'extension_instance_id',
                '=',
                'integer',
                $query->get('extension_instance_id')
            );
        }

        if ($query->get('catalog_type_id', 0) == 0) {
        } else {
            $this->whereCriteria(
                'column',
                'catalog_type_id',
                '=',
                'integer',
                $query->get('catalog_type_id')
            );
        }

        try {
            $values = $query->getData();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        $query_results = array();

        $temp_row = new stdClass();

        $temp_row->listitems = $values;
        $temp_row->multiple  = $multiple;
        $temp_row->size      = $size;

        $query_results[] = $temp_row;

        return $query_results;
    }

    /**
     * Set Where Criteria
     *
     * @param   string $field
     * @param   string $value
     * @param   string $alias
     * @param   array  $query
     *
     * @return  array
     * @since   1.0
     */
    protected function whereCriteria($field, $value, $alias, $query)
    {
        if (strrpos($value, ',') > 0) {
            $query->where(
                $alias
                . '.'
                . $field
                . ' IN (' . $value . ')'
            );
        } elseif ((int)$value == 0) {
        } else {
            $query->where(
                $alias
                . '.'
                . $field
                . ' = '
                . (int)$value
            );
        }

        return;
    }

    /**
     * Add Published Status Query Criteria
     *
     * @param   array  $query
     * @param   string $primary_prefix
     *
     * @return  array
     * @since   1.0
     */
    protected function publishedStatus(array $query = array(), $primary_prefix = 'a')
    {
        $query->where(
            $primary_prefix
            . '.'
            . 'status'
            . ' > '
            . 0
        );

        $query->where(
            '('
            . $primary_prefix
            . '.'
            . 'start_publishing_datetime'
            . ' = '
            . $query->model->null_date
            . ' OR '
            . $primary_prefix
            . '.'
            . 'start_publishing_datetime'
            . ' <= '
            . $query->model->now
            . ')'
        );

        $query->where(
            '('
            . $primary_prefix
            . '.'
            . 'stop_publishing_datetime'
            . ' = '
            . $query->model->null_date
            . ' OR '
            . $primary_prefix
            . '.'
            . 'stop_publishing_datetime'
            . ' >= '
            . $query->model->now
            . ')'
        );

        return $query;
    }

    /**
     * Build Select Lists for insertion into Template
     *
     * @param   string $queryname
     * @param   array  $items
     * @param   int    $multiple
     * @param   int    $size
     * @param   string $selected
     *
     * @return  array
     * @since   1.0
     */
    public function buildSelectList($queryname, $items, $multiple = 0, $size = 5, $selected = null)
    {
        $query_results = array();

        if (count($items) == 0) {
            return false;
        }

        foreach ($items as $item) {

            $temp_row = new stdClass();

            $temp_row->list_name = $queryname;
            $temp_row->id        = $item->id;
            $temp_row->value     = $item->value;

            if ($temp_row->id == $selected) {
                $temp_row->selected = ' selected ';
            } else {
                $temp_row->selected = '';
            }

            $temp_row->multiple = '';

            if ($multiple == 1) {
                $temp_row->multiple = ' multiple ';
                if ((int)$size == 0) {
                    $temp_row->multiple .= 'size=5 ';
                } else {
                    $temp_row->multiple .= 'size=' . (int)$size;
                }
            }
            $query_results[] = $temp_row;
        }

        return $query_results;
    }

    /**
     * Generates Lorem Ipsum Placeholder Text
     *
     * Usage:
     * $text->getPlaceHolderText(2, 3, 7, 'p', true);
     *  Generates 2 paragraphs, each with 3 lines of 7 random words each, each paragraph starting with 'Lorem ipsum'
     *
     * $text->getPlaceHolderText(1, 1, 3, 'h1', false);
     *  Generates 1 <h1> line using 3 random words
     *
     * $text->getPlaceHolderText(1, 10, 3, 'li', false);
     *  Generates 1 <ul> list with 10 items each with 3 random words
     *
     * @param   int    $number_of_paragraphs
     * @param   int    $lines_per_paragraphs
     * @param   int    $words_per_line
     * @param   string $markup_type ('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote')
     * @param   bool   $start_with_lorem_ipsum
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
        $start_with_lorem_ipsum = true
    ) {
        $count_lorem_set = count($this->lorem_set) - 1;
        if ($count_lorem_set < 10) {
            throw new RuntimeException(
                'Text Utility: getPlaceHolderText requires more than 10 lorem_set words.'
            );
        }

        if ((int)$number_of_paragraphs === 0) {
            $number_of_paragraphs = 3;
        }

        if ((int)$lines_per_paragraphs === 0) {
            $lines_per_paragraphs = 3;
        }

        if ((int)$words_per_line === 0) {
            $words_per_line = 7;
        }

        $valid = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'blockquote');
        if (in_array($markup_type, $valid)) {
        } else {
            $markup_type = 'p';
        }

        if ($start_with_lorem_ipsum === false) {
        } else {
            $start_with_lorem_ipsum = true;
        }

        $output = '';

        if ($markup_type == 'ul' || $markup_type == 'ol') {
            $output = '<' . $markup_type . '>';
            $begin  = '<li>';
            $end    = '</li>';
        } else {
            $begin = '<' . $markup_type . '>';
            $end   = '</' . $markup_type . '>';
        }

        for ($paragraph_count = 0; $paragraph_count < $number_of_paragraphs; $paragraph_count ++) {
            $output .= $begin;

            for ($line_count = 0; $line_count < $lines_per_paragraphs; $line_count ++) {

                for ($word_count = 0; $word_count < $words_per_line; $word_count ++) {

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
                $output .= '.';
            }
            $output .= $end;
        }

        if ($markup_type == 'ul' || $markup_type == 'ol') {
            $output .= '</' . $markup_type . '>';
        }

        return $output;
    }
}
