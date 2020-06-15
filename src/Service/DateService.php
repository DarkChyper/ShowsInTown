<?php


namespace App\Service;


class DateService
{
    const DAY = "days";
    const WEEK = "weeks";
    const MONTH = "months";
    const YEAR = "years";

    /**
     * DateService constructor.
     */
    public function __construct()
    {
    }


    /**
     * Get the $time $unit date in the future
     * ie today + 3 months
     * $unit are defines by constants DAY, WEEK, MONTH and YEAR
     * return today date if $unit is anything else
     *
     * @param int $time
     * @param string $unit
     * @return false|string
     */
    public function getDateInFuture(int $time,$unit){
        switch ($unit){
            case self::DAY:
            case self::WEEK:
            case self::MONTH:
            case self::YEAR:
                return date('d-m-Y', strtotime('+'. $time . ' '. $unit));
            default: return date("d-m-Y");;
        }
    }
}