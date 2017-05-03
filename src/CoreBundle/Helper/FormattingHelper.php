<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 01.03.2017
 * Time: 23:00
 */

namespace CoreBundle\Helper;


abstract class FormattingHelper
{

    /**
     * @param \DateTime $datetime
     * @param string $format
     * @param string $timezone
     * @return null|string
     */
    public static function formatDateTime($datetime, $format = DATE_ISO8601, $timezone = 'UTC')
    {
        $formatted 				= null;
        if ($datetime instanceof \DateTime)
        {
            $datetime->setTimezone(new \DateTimeZone($timezone));
            $formatted 			= $datetime->format($format);
        }
        return $formatted;
    }

}