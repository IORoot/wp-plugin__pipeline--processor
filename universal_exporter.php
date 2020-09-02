<?php
/*
 * 
 * @wordpress-plugin
 * Plugin Name:       _ANDYP - Universal Exporter
 * Plugin URI:        http://londonparkour.com
 * Description:       <strong>🔌PLUGIN</strong> | <em>ANDYP > Universal Exporter</em> | Automatically export posts to targets.
 * Version:           1.0.0
 * Author:            Andy Pearson
 * Author URI:        https://londonparkour.com
 * Domain Path:       /languages
 */

define( 'ANDYP_UE_URL', plugins_url( '/', __FILE__ ) );
define( 'ANDYP_UE_PATH', __DIR__ );


// ┌─────────────────────────────────────────────────────────────────────────┐
// │                         Use composer autoloader                         │
// └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/vendor/autoload.php';
    

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                               The CPT                                   │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/cpt/exporter_cpt.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                          The ACF Admin Page                             │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/acf/acf_init.php';





function my_datepicker_admin_enqueue_scripts() {
	wp_enqueue_script( 'date-picker-js', '/wp-content/plugins/andyp_universal_exporter/src/acf/js/custom_date_picker.js', array(), '1.0.0', true );
}

add_action('admin_enqueue_scripts', 'my_datepicker_admin_enqueue_scripts');