<?php
/**
 * Date Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\DateController;

/**
 * Utilities Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $options;

    /**
     * @covers  Molajo\Controller\DateController::__construct
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetDate()
    {
        $date = new DateController();
        $test = $date->getDate();

        $this->assertEquals(true, is_string($test));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * @return  $this
     * @since   1.0
     */
    public function testGet()
    {
        //date_default_timezone_set('America/Chicago');

        $date = new DateController();
        $date->set('timezone_server', 'America/Chicago');

        $test = $date->get('timezone_server');

        $this->assertEquals('America/Chicago', $test);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetDate2()
    {
        $date = new DateController();
        $test = $date->getDate('1961-09-17');

        $value = '1961-09-17 00:00:00';
        $this->assertEquals('1961-09-16 18:00:00', $test);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * @return  $this
     * @since   1.0
     */
    public function testConvertCCYYMMDD()
    {
        $date = new DateController();
        $test = $date->getDate('1961-09-17');

        $results = $date->convertCCYYdashMMdashDD($test);

        $value = '1961-09-17';
        $this->assertEquals('1961-09-16', $results);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetNumberofDaysAgo()
    {
        $date  = new DateController();
        $date1 = $date->getDate('1961-09-17');
        $date2 = $date->getDate('1962-09-17');

        $days = $date->getNumberofDaysAgo($date1, $date2);

        $value = 365;
        $this->assertEquals($value, $days);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetPrettyDate()
    {
        $date  = new DateController();
        $date1 = $date->getDate('1961-09-17');
        $date2 = $date->getDate('1962-09-17');

        $days = $date->getPrettyDate($date1, $date2);

        $value = '1 year ago';
        $this->assertEquals($value, $days);

        $date  = new DateController();
        $date1 = $date->getDate('1961-09-17 00:00:00');
        $date2 = $date->getDate('1961-09-17 00:05:00');

        $days = $date->getPrettyDate($date1, $date2);

        $value = '5 minutes ago';
        $this->assertEquals($value, $days);

        $date  = new DateController();
        $date1 = $date->getDate('1961-09-16 00:00:00');
        $date2 = $date->getDate('1961-09-17 00:00:00');

        $days = $date->getPrettyDate($date1, $date2);

        $value = 'Yesterday';
        $this->assertEquals($value, $days);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     *  Tests translate and getDayName
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetDayName()
    {
        $date    = new DateController();
        $dayname = $date->getDayName(1);

        $value = 'Thursday';
        $this->assertEquals($value, $dayname);

        $date    = new DateController();
        $dayname = $date->getDayName(7, true);

        $value = 'Thu';
        $this->assertEquals($value, $dayname);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * Tests translate and getMonthName
     *
     * @return  $this
     * @since   1.0
     */
    public function testGetMonthName()
    {
        $date      = new DateController();
        $monthname = $date->getMonthName(1);

        $value = 'January';
        $this->assertEquals($value, $monthname);

        $date      = new DateController();
        $monthname = $date->getMonthName(7, true);

        $value = 'Jul';
        $this->assertEquals($value, $monthname);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     * @covers  Molajo\Controller\DateController::get
     * @covers  Molajo\Controller\DateController::set
     * @covers  Molajo\Controller\DateController::getDate
     * @covers  Molajo\Controller\DateController::getDateTimezone
     * @covers  Molajo\Controller\DateController::getDateFormatDate
     * @covers  Molajo\Controller\DateController::convertCCYYMMDD
     * @covers  Molajo\Controller\DateController::getNumberofDaysAgo
     * @covers  Molajo\Controller\DateController::formatDate
     * @covers  Molajo\Controller\DateController::getPrettyDate
     * @covers  Molajo\Controller\DateController::getPrettyDateToday
     * @covers  Molajo\Controller\DateController::getPrettyDateNotToday
     * @covers  Molajo\Controller\DateController::getDayName
     * @covers  Molajo\Controller\DateController::getMonthName
     * @covers  Molajo\Controller\DateController::getNameTranslated
     * @covers  Molajo\Controller\DateController::buildCalendar
     * @covers  Molajo\Controller\DateController::translatePrettyDate
     * @covers  Molajo\Controller\DateController::translate
     *
     * Tests translate and getMonthName
     *
     * @return  $this
     * @since   1.0
     */
    public function testBuildCalendar()
    {
        $date     = new DateController();
        $calendar = $date->buildCalendar(12, 2013);

        $this->assertEquals('S', $calendar[0]->days_of_week[0]);
        $this->assertEquals('31', $calendar[0]->number_of_days);
        $this->assertEquals('December', $calendar[0]->month_name);
        $this->assertEquals(0, $calendar[0]->day_of_week_number);
        $this->assertEquals('Sunday', $calendar[0]->day_of_week_name);

        return $this;
    }
}
