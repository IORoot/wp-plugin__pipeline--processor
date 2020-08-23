<?php

namespace ue\utils;

trait array_flat
{

    public static function array_flat($array, $prefix = '')
    {
        $result = array();

        foreach ($array as $key => $value)
        {
            if ($prefix == '') { $sep = ''; } else { $sep = '_'; }
            $new_key = $prefix . $sep . $key;

            if (is_array($value))
            {
                $result = array_merge($result, self::array_flat($value, $new_key));
            }
            else
            {
                $result[$new_key] = $value;
            }
        }

        return $result;
    }

}


