<?php

/**
 * SEE populate_ue_process_input_field for the mutation_input_choices class.
 */

function acf_populate_ue_combine_input_select_choices($field)
{
    $options = new field_input_choices();
    
    $field['choices'] = $options->get_result();

    return $field;
}

add_filter('acf/prepare_field/key=field_5f70506e00672', 'acf_populate_ue_combine_input_select_choices');