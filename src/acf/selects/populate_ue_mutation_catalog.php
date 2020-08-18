<?php

function acf_populate_ue_mutation_catalog_choices($value)
{

    $value = [];
    
    $type = 'mutations';

    $helper = new \ue\interfaces;
    $list = $helper->list_catalog($type);

    foreach($list as $item)
    {
        $entry = [
            "field_5f3a30f27bccd" => $item['name'],
            "field_5f3a311d7bcce" => $item['description'],
            "field_5f3a31467bccf" => $item['parameters'],
        ];
    
        $value[] = $entry;
    }

    return $value;

}

add_filter('acf/load_value/name=ue_mutation_catalog', 'acf_populate_ue_mutation_catalog_choices');