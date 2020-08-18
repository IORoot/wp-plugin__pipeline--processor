<?php

namespace ue\utils;

trait string_to_wpquery {

    public static function string_to_wpquery($query)
    {
        
        $wp_query = preg_replace("/\r|\n/", "", $query);
        $wp_query = eval("return " . $wp_query . ";");

        return $wp_query;
    }

}