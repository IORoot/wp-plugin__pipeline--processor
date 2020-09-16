<?php

// ┌───────────────────────────────────────────────────────────────────────────┐
// │Explanations at:                                                           │
// │- https://dev.to/ioroot/google-oauth-wordpress-youtube-service-api-4ko6    │
// │- https://ioroot.com/wordpress-oauth-and-ajax/                             │
// │- https://github.com/IORoot/wp-plugin__oauth-demo                          │
// └───────────────────────────────────────────────────────────────────────────┘

class ue_oauth
{

    public function __construct()
    {
        
        $this->setup_decode_state();
        $this->setup_oauth('youtube');
        $this->setup_oauth('gmb');

    }

    private function setup_oauth($service)
    {
        /**
         * Load the Javascript into the Admin page footer.
         */
        require __DIR__.'/'.$service.'/actions/enqueue_js.php';

        /**
         * Create the AJAX callback action for the redirect
         * back to the app.
         */
        require __DIR__.'/'.$service.'/actions/oauth_callback.php';
    }

    /* 
    * This is specifically for the GOOGLE OAUTH SERVER.
    * 
    * Google returns a 'state' parameter with a base64, json encoded array
    * of key-pairs that need to be added to the $_REQUEST array.
    */
    private function setup_decode_state()
    {
        require __DIR__.'/google/decode_state.php';
    }

}

/**
 * Initialise to setup all actions.
 */
new ue_oauth();