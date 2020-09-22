<?php

class oauth_gmb_client
{

    private $client;


    public function run()
    {
        $this->get_tokens();

        // use existing refresh code.
        if ( false !== ( $this->refresh_token ) ) {
            $this->use_refresh_token();
            return;
        }

        // No Auth Code - which means OAuth button not pressed.
        if ( false === ( $this->auth_token ) ) { return; }

        // Have Auth Token - button pressed.
        $this->authenticate();
        
    }


    public function get_client()
    {
        return $this->client;
    }


    //  ┌─────────────────────────────────────────────────────────────────────────┐
    //  │                                                                         │░
    //  │                                                                         │░
    //  │                                 PRIVATE                                 │░
    //  │                                                                         │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░



    /**
     * get_tokens
     * 
     * This will get any tokens stored as transients.
     *
     * @return void
     */
    private function get_tokens()
    {
        $this->auth_token = get_transient( 'GMB_OAUTH_CODE' );
        $this->refresh_token = get_transient( 'GMB_OAUTH_REFRESH_TOKEN' );
    }


    /**
     * create_client
     *
     * Uses the google client library.
     * 
     * @return void
     */
    private function create_client()
    {
        $this->client = new Google_Client([
            'api_format_v2' => true
        ]);
        
        $this->client->setAuthConfigFile(GOOGLE_APPLICATION_CREDENTIALS);

        $this->client->addScope('https://www.googleapis.com/auth/business.manage');

        $this->client->setPrompt('consent');  // Needed to get refresh_token every time.

        $this->client->setAccessType('offline');
    }




    /**
     * get_auth_token 
     * 
     * Not autenticated yet, so do so and set the refresh token.
     * 
     * Refresh token set for 1 year.
     * 
     * @return void
     */
    private function authenticate()
    {
        $this->create_client();

        $this->client->authenticate($this->auth_token);

        $this->refresh_token = $this->client->getRefreshToken();

        set_transient( 'GMB_OAUTH_REFRESH_TOKEN', $this->refresh_token, WEEK_IN_SECONDS );

    }



    /**
     * use_refresh_token 
     * 
     * Already authenticated and have a refresh token.
     *
     * @return void
     */
    private function use_refresh_token()
    {
        $this->create_client();

        $refresh_token = get_transient( 'GMB_OAUTH_REFRESH_TOKEN' );

        $this->client->refreshToken($refresh_token);

    }



}