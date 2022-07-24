<?php

/**
 * @param $date
 * @param string $format
 * @return null
 */
function formatDate($date, string $format = DATE_FORMAT)
{
    if (isset($date)) {
        return \Carbon\Carbon::parse($date)->format($format);
    }

    return null;
}
