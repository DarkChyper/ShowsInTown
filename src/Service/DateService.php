<?php


namespace App\Service;


class DateService
{
    const DAY = "days";
    const WEEK = "weeks";
    const MONTH = "months";
    const YEAR = "years";

    /**
     * @param int $time
     * @param $unit
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