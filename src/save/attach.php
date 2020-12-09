<?php

namespace ue\import;

class attach
{
    
    public function __construct()
    {
        return $this;
    }


    public function meta_to_post($metadata, $post_id)
    {
        if ($metadata == null || $post_id == null) { return; }

        foreach($metadata as $meta_key => $meta_value)
        {
            update_post_meta($post_id, $meta_key, $meta_value);
        }

        return;
    }


    public function tax_to_post($tax_type, $tax_term, $post_id)
    {
        if (!isset($tax_term) || empty($tax_term)) { return; }
        if (!isset($tax_type) || empty($tax_type)) { return; }
        if (!isset($post_id)  || empty($post_id)) {  return; }

        return wp_set_object_terms($post_id, $tax_term, $tax_type, true);

    }

}
