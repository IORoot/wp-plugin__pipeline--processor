<?php

function acf_populate_processor_mutation_genimage_filters_choices( $field ) {
    
    // reset choices
    $field['choices'] = [];
    
    // Is plugin installed?
    if (!is_plugin_active('andyp_pipeline_generative_images/generative_images.php')){
        $field['choices']['Empty'] = 'Image Generator Plugin not installed.';
        return $field;
    }

    $choices = get_field('genimage_filters', 'option', true);

    // Are there filters?
    if (empty($choices)){
        $field['choices']['Empty'] = 'No filters in Image Generator Plugin.';
        return $field;
    }

    if( is_array($choices) ) {
        
        foreach( $choices as $choice ) {
            $choice_name = $choice['genimage_filter_group']['genimage_filter_slug'];
            $field['choices'][ $choice_name ] = $choice_name;
        }   
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=filter_slug', 'acf_populate_processor_mutation_genimage_filters_choices');