<?php
/*
 * 
 * @wordpress-plugin
 * Plugin Name:       _ANDYP - Pipeline - Processor
 * Plugin URI:        http://londonparkour.com
 * Description:       <strong>🤖 Pipeline</strong> | <em>Pipeline > The Processor</em> | Automatically process posts to new posts
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
require __DIR__.'/src/cpt/add_image_column.php';
require __DIR__.'/src/cpt/exporter_cpt.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                          The ACF Admin Page                             │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/acf/acf_init.php';