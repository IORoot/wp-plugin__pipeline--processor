<?php


function acf_populate_ue_combine_input_select_choices($field)
{

    /**
     * See  src/process/process.php::update_combine_selects() 
     * 
     * The fields are automatically updated from this method
     * once they are processed.
     * 
     * This is the only way to get the processing results and
     * populate the 'combine' fields from those results.
     */
    return $field;
}

add_filter('acf/prepare_field/name=ue_combine_input_select', 'acf_populate_ue_combine_input_select_choices');