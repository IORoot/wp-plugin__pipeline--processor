<?php

/**
 * NOTE - Make sure that :
 * 
 * 1. You have downloaded the crendials json file from the google api console.
 * 2. Saved it in the root of the project called client_secret.json
 * 3. The .gitignore is listing that file (so you don't add it to git!)
 * 4. define('GOOGLE_APPLICATION_CREDENTIALS', __DIR__.'/client_secret.json');
 * 
 * This action will add the youtube_oauth.js file into the footer of the admin
 * page.
 * 
 * It requires ACF and the google client library from https://github.com/googleapis/google-api-php-client.
 */
add_action( 'admin_enqueue_scripts', 'enqueue_youtube_oauth' );

function enqueue_youtube_oauth() {
    
    /**
     * Add script to footer.
     */
	wp_enqueue_script( 'youtube-oauth-ajax-script', plugins_url( '../js/youtube_oauth.js', __FILE__ ), array('acf-input'), '5.8.7');

    /**
     * Generate AUTH URL
     */
    $client = new Google_Client();
    $client->setAuthConfig(GOOGLE_APPLICATION_CREDENTIALS);
    $client->addScope(Google_Service_YouTube::YOUTUBE_FORCE_SSL);
    $client->setPrompt('consent');  // Needed to get refresh_token every time.
    $client->setAccessType('offline');
    
    /**
     * The "action" parameter tells the admin-ajax.php system which 
     * Action to run.
     * In this case, the action is "youtube_oauth" which is defined
     * as an AJAX endpoint in the /actions/oauth_callback.php file.
     */
    $args = array(
        'action' => 'youtube_oauth',
    );
    $state = base64_encode( json_encode( $args ) );
    // $state = '&action=youtube_oauth';
    $client->setState($state);

    /**
     * Create the Authentication URL based off the state and client
     * details.
     */
    $auth_url = $client->createAuthUrl();

    /**
     * Make these values accessible in the Javascript file.
     * 
     * In JavaScript, these object properties are accessed as 
     * ajax_object.ajax_url
     * ajax_object.auth_url
     */
    wp_localize_script( 'youtube-oauth-ajax-script', 'youtube_ajax_object', 
        [
            'ajax_url' => admin_url( 'admin-ajax.php' ), 
            'auth_url' => $auth_url
        ] 
    );
    
}