<?php

add_action( 'wp_ajax_gmb_oauth', 'gmb_oauth' );

function gmb_oauth() {

    set_transient( 'GMB_OAUTH_CODE', $_REQUEST['code'], 300 );

    echo "OAUTH_CODE Transient set for 5 minutes.<br/>";
    echo "OAUTH_REFRESH_CODE Transient will be set for one year.<br/>";
    echo "Please now close this window.";

    wp_die(); // this is required to return a proper response
    
}

/**
 * AJAX Callback used to clear all tokens.
 */
add_action( 'wp_ajax_delete_gmb_oauth_transients', 'delete_gmb_oauth_transients' );

function delete_gmb_oauth_transients() {

    delete_transient( 'GMB_OAUTH_CODE' );
    delete_transient( 'GMB_OAUTH_REFRESH_TOKEN' );
    wp_send_json_success( 'GMB Tokens Deleted', 200 );
    wp_die(); // this is required to return a proper response
}