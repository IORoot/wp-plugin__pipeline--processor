<?php


/**
 * AJAX Callback for completion of OAUTH.
 * 
 * Google will call this endpoint.
 */
add_action( 'wp_ajax_youtube_oauth', 'youtube_oauth' );

function youtube_oauth() {

    set_transient( 'YT_OAUTH_CODE', $_REQUEST['code'], 300 );

    echo "Code = ".$_REQUEST['code'] . "</br></br>";
    echo "Action = ".$_REQUEST['action'] . "</br></br>";
    echo "State = ".$_REQUEST['state'] . "</br></br>";
    echo "Scope = ".$_REQUEST['scope'] . "</br></br>";
    echo "OAUTH_CODE Transient set for 5 minutes.<br/><br/>";
    echo "OAUTH_REFRESH_CODE Transient will be set for one year.<br/><br/>";
    echo "Please now close this window.";

    wp_die(); // this is required to return a proper response
    
}



/**
 * AJAX Callback used to clear all tokens.
 */
add_action( 'wp_ajax_delete_youtube_oauth_transients', 'delete_youtube_oauth_transients' );

function delete_youtube_oauth_transients() {
    delete_transient( 'YT_OAUTH_CODE' );
    delete_transient( 'YT_OAUTH_REFRESH_TOKEN' );
    wp_send_json_success( 'YouTube Tokens Deleted', 200 );
    wp_die(); // this is required to return a proper response
}