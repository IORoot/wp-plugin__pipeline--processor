<?php

function acf_populate_ue_save_posttype_choices($field)
{
    $field['choices'] = get_post_types();
    $field['choices']['none'] = 'none';
    return $field;
}

add_filter('acf/load_field/name=ue_save_posttype', 'acf_populate_ue_save_posttype_choices');