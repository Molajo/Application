<?php
/**
 * Date Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\DateInterface;
use DateTime;
use DateTimeZone;
use stdClass;

/**
 * Date Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class DateController extends DateTime implements DateInterface
{
    /**
     * Offset for User Time zone
     *
     * @var    string
     * @since  1.0
     */
    protected $timezone_user = 'America/Chicago';

    /**
     * Offset for Server Time zone
     *
     * @var    string
     * @since  1.0
     */
    protected $timezone_server = 'America/Chicago';

    /**
     * Translation Strings for Dates
     *
     * @var    array
     * @since  1.0
     */
    protected $date_translate_array
        = array
        (
            'AGO'                  => 'ago',
            'DATE_MINUTE_SINGULAR' => 'minute',
            'DATE_MINUTE_PLURAL'   => 'minutes',
            'DATE_HOUR_SINGULAR'   => 'hour',
            'DATE_HOUR_PLURAL'     => 'hours',
            'DATE_DAY_SINGULAR'    => 'day',
            'DATE_DAY_PLURAL'      => 'days',
            'DATE_WEEK_SINGULAR'   => 'week',
            'DATE_WEEK_PLURAL'     => 'weeks',
            'DATE_MONTH_SINGULAR'  => 'month',
            'DATE_MONTH_PLURAL'    => 'months',
            'DATE_YEAR_SINGULAR'   => 'year',
            'DATE_YEAR_PLURAL'     => 'years',
            'DATE_MON'             => 'Mon',
            'DATE_MONDAY'          => 'Monday',
            'DATE_TUE'             => 'Tue',
            'DATE_TUESDAY'         => 'Tuesday',
            'DATE_WED'             => 'Wed',
            'DATE_WEDNESDAY'       => 'Wednesday',
            'DATE_THU'             => 'Thu',
            'DATE_THURSDAY'        => 'Thursday',
            'DATE_FRI'             => 'Fri',
            'DATE_FRIDAY'          => 'Friday',
            'DATE_SAT'             => 'Sat',
            'DATE_SATURDAY'        => 'Saturday',
            'DATE_SUN'             => 'Sun',
            'DATE_SUNDAY'          => 'Sunday',
            'DATE_JAN'             => 'Jan',
            'DATE_JANUARY'         => 'January',
            'DATE_FEB'             => 'Feb',
            'DATE_FEBRUARY'        => 'February',
            'DATE_MAR'             => 'Mar',
            'DATE_MARCH'           => 'March',
            'DATE_APR'             => 'Apr',
            'DATE_APRIL'           => 'April',
            'DATE_MAY'             => 'May',
            'DATE_JUN'             => 'Jun',
            'DATE_JUNE'            => 'June',
            'DATE_JUL'             => 'Jul',
            'DATE_JULY'            => 'July',
            'DATE_AUG'             => 'Aug',
            'DATE_AUGUST'          => 'August',
            'DATE_SEP'             => 'Sep',
            'DATE_SEPTEMBER'       => 'September',
            'DATE_OCT'             => 'Oct',
            'DATE_OCTOBER'         => 'October',
            'DATE_NOV'             => 'Nov',
            'DATE_NOVEMBER'        => 'November',
            'DATE_DEC'             => 'Dec',
            'DATE_DECEMBER'        => 'December',
            'YESTERDAY'            => 'Yesterday'
        );

    /**
     * Month Names
     *
     * @var    array
     * @since  1.0
     */
    protected $month_names
        = array(
            1  => array('abbreviation' => 'JAN', 'name' => 'JANUARY'),
            2  => array('abbreviation' => 'FEB', 'name' => 'FEBRUARY'),
            3  => array('abbreviation' => 'MAR', 'name' => 'MARCH'),
            4  => array('abbreviation' => 'APR', 'name' => 'APRIL'),
            5  => array('abbreviation' => 'MAY', 'name' => 'MAY'),
            6  => array('abbreviation' => 'JUN', 'name' => 'JUNE'),
            7  => array('abbreviation' => 'JUL', 'name' => 'JULY'),
            8  => array('abbreviation' => 'AUG', 'name' => 'AUGUST'),
            9  => array('abbreviation' => 'SEP', 'name' => 'SEPTEMBER'),
            10 => array('abbreviation' => 'OCT', 'name' => 'OCTOBER'),
            11 => array('abbreviation' => 'NOV', 'name' => 'NOVEMBER'),
            12 => array('abbreviation' => 'DEC', 'name' => 'DECEMBER')
        );

    /**
     * Day names
     *
     * @var    array
     * @since  1.0
     */
    protected $day_names
        = array(
            1 => array('abbreviation' => 'MON', 'name' => 'MONDAY'),
            2 => array('abbreviation' => 'TUE', 'name' => 'TUESDAY'),
            3 => array('abbreviation' => 'WED', 'name' => 'WEDNESDAY'),
            4 => array('abbreviation' => 'THU', 'name' => 'THURSDAY'),
            5 => array('abbreviation' => 'FRI', 'name' => 'FRIDAY'),
            6 => array('abbreviation' => 'SAT', 'name' => 'SATURDAY'),
            7 => array('abbreviation' => 'SUN', 'name' => 'SUNDAY')
        );


    /**
     * Second Constants
     *
     * @var    array
     * @since  1.0
     */
    const MINUTE = 60;
    const HOUR = 3600;
    const DAY = 86400;
    const WEEK = 604800;
    const MONTH = 2629800;
    const YEAR = 31557600;

    /**
     * Constructor
     *
     * @param  null  $timezone_user
     * @param  null  $timezone_server
     * @param  array $date_translate_array
     *
     * @since  1.0
     */
    public function __construct(
        $timezone_user = null,
        $timezone_server = null,
        array $date_translate_array = array()
    ) {
        if ($timezone_user === null) {
        } else {
            $this->timezone_user = $timezone_user;
        }

        if ($timezone_server === null) {
        } else {
            $this->timezone_server = $timezone_server;
        }

        if (count($date_translate_array) > 0) {
            $this->date_translate_array = $date_translate_array;
        }
    }

    /**
     * Get the current value (or default) of the specified key
     *
     * @param   string $key
     * @param   mixed  $default
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key = null, $default = null)
    {
        $key = strtolower($key);

        if ($this->$key === null) {
            return $default;
        }

        return $this->$key;
    }

    /**
     * Set the value of the specified key
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  mixed
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function set($key, $value = null)
    {
        $key = strtolower($key);

        $this->$key = $value;

        return $this->$key;
    }

    /**
     * Prepares Date object
     *
     * @param   string $time
     * @param   null   $timezone
     * @param   string $server_or_user_timezone
     * @param   string $date_format
     *
     * @return  string
     * @since   1.0
     */
    public function getDate(
        $time = 'now',
        $timezone = null,
        $server_or_user_timezone = 'user',
        $date_format = 'Y-m-d H:i:s'
    ) {
        if ($time == '') {
            $time = 'now';
        }

        $timezone = $this->getDateTimezone($timezone, $server_or_user_timezone);

        $tz        = new DateTimeZone($timezone);
        $date_time = new DateTime($time);
        $date_time->setTimezone($tz);

        return $this->getDateFormatDate($date_time, $date_format);
    }

    /**
     * Get Timezone
     *
     * @param   string $timezone
     * @param   string $server_or_user_timezone
     *
     * @return  string
     */
    protected function getDateTimezone($timezone = null, $server_or_user_timezone = 'server')
    {
        if ($timezone === null) {
            if ($server_or_user_timezone == 'server') {
                $timezone = $this->timezone_server;
            } else {
                $timezone = $this->timezone_user;
            }
        }

        return $timezone;
    }

    /**
     * Format Date
     *
     * @param   DateTime $date_time
     * @param   string   $date_format
     *
     * @return  string
     */
    protected function getDateFormatDate(DateTime $date_time, $date_format)
    {
        if ($date_format == null) {
            $date_format = 'Y-m-d H:i:s';
        }

        if ($date_format == 'd-m-YY') {
            $date = strtotime($date_time->format('d-m-YY'));
        } else {
            $date = $date_time->format($date_format);
        }

        return (string)$date;
    }

    /**
     * Converts standard MYSQL date (ex. 2011-11-11 11:11:11) to CCYY-MM-DD format (ex. 2011-11-11)
     *
     * @param   string $date
     *
     * @return  string CCYY-MM-DD
     * @since   1.0
     */
    public function convertCCYYMMDD($date = null)
    {
        return substr($date, 0, 4) . '-' . substr($date, 5, 2) . '-' . substr($date, 8, 2);
    }

    /**
     * Get the number of days between two dates
     *
     * @param   string $date1
     * @param   string $date2
     *
     * @since   1.0
     * @return  integer
     */
    public function getNumberofDaysAgo($date1, $date2 = null)
    {
        if ($date2 === null) {
            $date2 = $this->convertCCYYMMDD($this->getDate());
        }

        $date1 = $this->formatDate($date1);
        $date2 = $this->formatDate($date2);

        $day_object = $date1->diff($date2);

        return $day_object->days;
    }

    /**
     * Format Date
     *
     * @param   string $date
     *
     * @return  DateTime
     * @since   1.0
     */
    protected function formatDate($date)
    {
        return new DateTime(substr($date, 5, 2) . '/' . substr($date, 8, 2) . '/' . substr($date, 0, 4));
    }

    /**
     * Get Pretty Date
     *
     * @param   string $date
     * @param   string $compare_to_date
     *
     * @return  string formatted pretty date
     * @since   1.0
     */
    public function getPrettyDate($date, $compare_to_date = null)
    {
        $source_date = new Datetime($date);

        if ($compare_to_date === null) {
            $compare_to_date = new Datetime();
        } else {
            $compare_to_date = new Datetime($compare_to_date);
        }

        $interval       = $source_date->diff($compare_to_date);
        $day_difference = $interval->days;

        if ($day_difference == 0) {
            $pretty_date = $this->getPrettyDateToday($interval);
        } else {
            $pretty_date = $this->getPrettyDateNotToday($interval);
        }

        return $pretty_date;
    }

    /**
     * Provides translated name of day in abbreviated or full format, given day number
     *
     * @param   string  $day_number
     * @param   boolean $abbreviation
     *
     * @return  string
     * @since   1.0
     */
    public function getDayName($day_number, $abbreviation = false)
    {
        return $this->getNameTranslated('day', $day_number, $abbreviation);
    }

    /**
     * Provides translated name of month in abbreviated or full format, given month number
     *
     * @param   string  $month_number
     * @param   boolean $abbreviation
     *
     * @return  string
     * @since   1.0
     */
    public function getMonthName($month_number, $abbreviation = false)
    {
        return $this->getNameTranslated('month', $month_number, $abbreviation);
    }

    /**
     * Provides translated name of month in abbreviated or full format, given month number
     *
     * @param   string  $type
     * @param   integer $index
     * @param   boolean $abbreviation
     *
     * @return  string
     * @since   1.0
     */
    public function getNameTranslated($type, $index, $abbreviation)
    {
        if ($type === 'day') {
            $value = $this->day_names[$index];
        } else {
            $value = $this->month_names[$index];
        }

        if ($abbreviation === true) {
            return $this->translate('DATE_' . $value['abbreviation']);
        }

        return $this->translate('DATE_' . $value['name']);
    }

    /**
     * buildCalendar
     *
     * $d     = getDate();
     * $month = $d['mon'];
     * $year  = $d['year'];
     *
     * $calendar = $this->date->buildCalendar ($month, $year);
     *
     * @param   string $month
     * @param   string $year
     *
     * @return  stdClass[] CCYY-MM-DD
     * @since   1.0
     */
    public function buildCalendar($month, $year)
    {
        $temp_row                     = new stdClass();
        $temp_row->days_of_week       = array('S', 'M', 'T', 'W', 'T', 'F', 'S');
        $temp_row->first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
        $temp_row->number_of_days     = date('t', $temp_row->first_day_of_month);
        $temp_row->date_resources     = getdate($temp_row->first_day_of_month);
        $temp_row->month_name         = $temp_row->date_resources['month'];
        $temp_row->day_of_week_number = $temp_row->date_resources['wday'];
        $temp_row->day_of_week_name   = $temp_row->date_resources['weekday'];

        return array($temp_row);
    }

    /**
     * Get Pretty Date: Day is Today
     *
     * @param   object $interval
     *
     * @return  string
     * @since   1.0
     */
    protected function getPrettyDateToday($interval)
    {
        if ($interval->h > 0) {
            $pretty_date = $interval->h . ' '
                . $this->translatePrettyDate($interval->h, 'hour')
                . ' ' . $this->translate('AGO');

        } elseif ($interval->i > 0) {
            $pretty_date = $interval->i . ' '
                . $this->translatePrettyDate($interval->i, 'minute')
                . ' ' . $this->translate('AGO');

        } else {
            $pretty_date = $this->translate('JUST_NOW');
        }

        return $pretty_date;
    }

    /**
     * Get Pretty Date: Day is NOT Today
     *
     * @param   object $interval
     *
     * @return  string
     * @since   1.0
     */
    protected function getPrettyDateNotToday($interval)
    {
        if ($interval->y > 0) {
            $pretty_date = $interval->y . ' ' . $this->translatePrettyDate($interval->y, 'year');

        } elseif ($interval->m > 0) {
            $pretty_date = $interval->m . ' ' . $this->translatePrettyDate($interval->m, 'month');

        } elseif ($interval->d > 1) {
            $pretty_date = $interval->d . ' ' . $this->translatePrettyDate($interval->d, 'day');

        } else {
            $pretty_date = $this->translate('YESTERDAY');
            return $pretty_date;
        }

        return $pretty_date . ' ' . $this->translate('AGO');
    }

    /**
     * translate Pretty Date
     *
     * @param   integer $numeric_value
     * @param   string  $type
     *
     * @return  string
     * @since   1.0
     */
    protected function translatePrettyDate($numeric_value, $type)
    {
        if ($numeric_value == 0) {
            return '';
        }

        if ($numeric_value == 1) {
            return strtolower($this->translate('DATE_' . strtoupper($type) . '_SINGULAR'));
        }

        return strtolower($this->translate('DATE_' . strtoupper($type) . '_PLURAL'));
    }

    /**
     * Translate the string
     *
     * @param   string $string
     *
     * @return  string
     * @since   1.0
     */
    protected function translate($string)
    {
        if (isset($this->date_translate_array[$string])) {
            return $this->date_translate_array[$string];
        }

        return $string;
    }
}
