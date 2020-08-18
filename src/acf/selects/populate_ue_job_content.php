<?php

function acf_populate_ue_job_content_choices( $field ) {
    
    $namespace ='ue';
    $instance = 'content';
    $prefix = $namespace . '_' . $instance . '_';

    // reset choices
    $field['choices'] = array();
    
    $choices = get_field($prefix.'instance', 'option', true);
    

    if( is_array($choices) ) {
        
        foreach( $choices as $choice ) {
            
            $choice_name = $choice[$prefix.'group'][$prefix.'id'];
            $field['choices'][ $choice_name ] = $choice_name;
            
        }
        
    }
    
    // Add 'none'
    $field['choices']['none'] = 'none';

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=ue_job_content_id', 'acf_populate_ue_job_content_choices');