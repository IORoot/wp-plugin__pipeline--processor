<?php

function acf_populate_ue_mutation_type_choices( $field ) {
    
    $type = 'mutations';

    $helper = new \ue\interfaces;
    $field['choices'] = $helper->list_filenames($type);

    // Add 'none'
    $field['choices']['none'] = 'none';

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=ue_mutation_type', 'acf_populate_ue_mutation_type_choices');