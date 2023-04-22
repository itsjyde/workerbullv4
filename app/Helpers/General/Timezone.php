<?php

namespace App\Helpers\General;

use Carbon\Carbon;

/**
 * Class Timezone.
 */
class Timezone
{
    /**
     * @param  string  $format
     * @return Carbon
     */
    public function convertToLocal(Carbon $date, $format = 'D M j G:i:s T Y'): string
    {
        return $date->setTimezone(auth()->user()->timezone ?? config('app.timezone'))->format($format);
    }

    public function convertFromLocal($date): Carbon
    {
        return Carbon::parse($date, auth()->user()->timezone)->setTimezone('UTC');
    }
}
