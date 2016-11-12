<?php

namespace Follower\CoreBundle\Helper;
/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 02:44
 */
class TimeHelper
{
    CONST SECONDS_OF_DAY = 86400;

    static function calculateSleepTime($dailyTransaction) {
        return (self::SECONDS_OF_DAY / $dailyTransaction) * 1.20;
    }
}