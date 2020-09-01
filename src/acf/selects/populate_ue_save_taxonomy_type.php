<?php

function acf_populate_ue_save_taxonomy_choices($field)
{
    $field['choices'] = get_taxonomies();
    $field['choices']['none'] = 'none';
    return $field;
}

add_filter('acf/load_field/name=ue_save_taxonomy', 'acf_populate_ue_save_taxonomy_choices');
