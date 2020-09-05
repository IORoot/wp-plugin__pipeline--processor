<?php

add_filter('manage_exporter_posts_columns', 'add_img_column');
add_filter('manage_exporter_posts_custom_column', 'manage_img_column', 10, 2);

function add_img_column($columns) {
    $columns['img'] = 'Featured Image';
    return $columns;
}

function manage_img_column($column_name, $post_id) {
    if( $column_name == 'img' ) {
        $attr = [
            width => '100px',
            height => '100px',
        ];
        echo get_the_post_thumbnail($post_id, 'thumbnail', $attr);
    }
    return $column_name;
}
