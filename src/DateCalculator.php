<?php
declare(strict_types=1);

namespace App;

use DateTime;
use DateInterval;
use InvalidArgumentException;

class DateCalculator {
    const MONTHS = [
        1  => 'january',
        2  => 'february',
        3  => 'march',
        4  => 'april',
        5  => 'may', 
        6  => 'june',
        7  => 'july',
        8  => 'august',
        9  => 'september',
        10 => 'october',
        11 => 'november',
        12 => 'december',
    ];

    /**
     * Calculate the bonus payment date for a given month
     * 
     * @throws InvalidArgumentException 
     */
    static function getBonusDateForMonth(int $month, int $year = null) : DateTime
    {
        if (null === $year) {
            $year = (int) (new DateTime('now'))->format('Y');
        }
        if ($year < 1970 || $year > 3000) {
            throw new InvalidArgumentException('$year supports a range from 1970 to 3000');
        }
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException('$month must be a valid month index, with Janurary being 1');
        }
        $dateString = sprintf('%d-%d-15', $year, $month);
        $date = new DateTime($dateString);
        $dayOfWeek = (int) $date->format('N');
        if ($dayOfWeek > 5) {
            $offset = 4 - ($dayOfWeek - 6); // Number of days to following wednesday
            $date->add(new DateInterval("P{$offset}D"));
        }
        return $date;
    }

    /**
     * Calculate the salary payment date for a given month
     * 
     * @throws InvalidArgumentException
     */
    static function getSalaryDateForMonth(int $month, int $year = null) : DateTime
    {
        if (null === $year) {
            $year = (int) (new DateTime('now'))->format('Y');
        }
        if ($year < 1970 || $year > 3000) {
            throw new InvalidArgumentException('$year supports a range from 1970 to 3000');
        }
        $monthName = self::monthIndexToMonthName($month);
        $dateString = sprintf('last day of %s %d', $monthName, $year);
        $lastDay = new DateTime($dateString);
        $dayOfWeek = (int) $lastDay->format('N');
        if ($dayOfWeek > 5) {
            $offset = $dayOfWeek - 5;
            $lastDay->sub(new DateInterval("P{$offset}D"));
        }
        return $lastDay;
    }

    /**
     * convert a month index to a month name
     * 
     * @throws InvalidArgumenteException
     */
    static function monthIndexToMonthName(int $month) : string
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException('$month must be a valid month index, with Janurary being 1');
        }
        return self::MONTHS[$month];
    }
}