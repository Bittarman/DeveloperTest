<?php

use App\DateCalculator;
use PHPUnit\Framework\TestCase;

class DateCalculatorTest extends TestCase 
{
    /**
     * Exercises the basic function of the DateCalculator::getBonusDateForMonth method
     * @dataProvider bonusDateProvider
     */
    public function testGetBonusDateBasic($month, $year, $expected, $message) 
    {
        $endDate = DateCalculator::getBonusDateForMonth($month, $year);
        $expectedEndDate = new DateTime($expected);
        $this->assertSame(
            $expectedEndDate->format('Y-m-d'), 
            $endDate->format('Y-m-d'),
            $message
        );
    }

    public function testGetBonusDateYear_InvalidMonth() 
    {
        $this->expectException(InvalidArgumentException::class);
        DateCalculator::getBonusDateForMonth(13);
    }

    public function testGetBonusDateYear_InvalidYearTooHigh() 
    {
        $this->expectException(InvalidArgumentException::class);
        DateCalculator::getBonusDateForMonth(4000);
    }

    public function testGetBonusDateYear_InvalidYearTooLow() 
    {
        $this->expectException(InvalidArgumentException::class);
        DateCalculator::getBonusDateForMonth(1969);
    }

    /**
     * Exercises the basic functionality of the getSalaryDateForMonth function
     *
     * @dataProvider salaryDateProvider
     */
    public function testGetSalaryDateForMonth($month, $year, $expected) 
    {
        $actualDate = DateCalculator::getSalaryDateForMonth($month, $year);
        $this->assertSame(
            $expected,
            $actualDate->format('Y-m-d')
        );
    }

    public function testGetSalaryDateForMonth_InvalidYear() {
        $this->expectException(InvalidArgumentException::class);
        DateCalculator::getSalaryDateForMonth(1, 1000);
    }

    public function testGetSalaryDateForMonth_InvalidMonth() {
        $this->expectException(InvalidArgumentException::class);
        DateCalculator::getSalaryDateForMonth(14);
    }

    public function salaryDateProvider() 
    {
        return [
            [1, null, '2018-01-31'],
            [2, null, '2018-02-28'],
            [3, null, '2018-03-30'],
            [4, null, '2018-04-30'],
            [5, null, '2018-05-31'],
            [6, null, '2018-06-29'],
            [7, null, '2018-07-31'],
            [8, null, '2018-08-31'],
            [9, null, '2018-09-28'],
            [10, null, '2018-10-31'],
            [11, null, '2018-11-30'],
            [12, null, '2018-12-31'],
            [1, 2017, '2017-01-31'],
            [12, 2019, '2019-12-31'],
        ];
    }

    /**
     * Provides test data for testGetBonusDateBasic
     * 
     * @return array
     */
    public function bonusDateProvider() 
    {
        return [
            [3,  2017, '2017-03-15', 'Check expected date matches given date for mar 2017'],
            [1,  null, '2018-01-15', 'Check expected date matches given date for jan 2018'],
            [4,  2018, '2018-04-18', 'Check expected date matches given date for april 2018'],
            [9,  null, '2018-09-19', 'Check expected date matches given date for sept 2018'],
            [12, null, '2018-12-19', 'Check expected date matches given date for dec 2018'],
            [6,  2019, '2019-06-19', 'Check expected date matches given date for jun 2019'],
            [7,  2019, '2019-07-15', 'Check expected date matches given date for jul 2019'],
        ];
    }

}