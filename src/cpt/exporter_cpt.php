<?php

// Register Custom Taxonomy
function exportercategory() {

	$labels = array(
		'name'                       => _x( 'Exporter Category', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Exporter Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Exporter Category', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => array('slug' => 'exporter', 'with_front' => false)
	);
	register_taxonomy( 'exportercategory', array( 'exporter' ), $args );
}
add_action( 'init', 'exportercategory', 0 );




// Register Custom Post Type
function CPT_Exporter() {

	$labels = array(
		'name'                  => 'Exporter',
		'singular_name'         => 'Exporter',
		'menu_name'             => 'Exporter',
		'name_admin_bar'        => 'Exporter',
		'archives'              => 'Exporter Archives',
		'attributes'            => 'Exporter Attributes',
		'parent_item_colon'     => 'Exporter :',
		'all_items'             => 'All Exporter',
		'add_new_item'          => 'Add New Exporter',
		'add_new'               => 'Add New',
		'new_item'              => 'New Exporter',
		'edit_item'             => 'Edit Exporter',
		'update_item'           => 'Update Exporter',
		'view_item'             => 'View Exporter',
		'view_items'            => 'View Exporters',
		'search_items'          => 'Search Exporter',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into article',
		'uploaded_to_this_item' => 'Uploaded to this article',
		'items_list'            => 'Exporter list',
		'items_list_navigation' => 'Exporter list navigation',
		'filter_items_list'     => 'Filter Exporter list',
	);
	$args = array(
		'label'                 => 'Exporter',
		'description'           => 'Universal Exporter',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array( 'exportercategory'),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-upload',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive' 			=> false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'               => array('slug' => 'exporter', 'with_front' => false),
	);
	register_post_type( 'exporter', $args );

}

add_action( 'init', 'CPT_Exporter', 0 );