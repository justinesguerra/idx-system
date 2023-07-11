<?php

namespace App\Traits;

use App\Models\AppConfig;

trait AppConfigTrait
{
    static function get($label, $is_array = false)
    {
        $query = AppConfig::where('label', $label)->first();

        if ($query == null)
            return null;

        if ($is_array)
            return json_decode($query->value, true);

        return $query->value;
    }
}
