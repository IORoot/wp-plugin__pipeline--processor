<?php

// namespace ue\exporter;

// ┌───────────────────────────────────────────────────────────────────────────┐
// │Explanations at:                                                           │
// │                                                                           │
// │- https://dev.to/ioroot/google-oauth-wordpress-youtube-service-api-4ko6    │
// │                                                                           │
// │- https://ioroot.com/wordpress-oauth-and-ajax/                             │
// │                                                                           │
// │- https://github.com/IORoot/wp-plugin__oauth-demo                          │
// │                                                                           │
// └───────────────────────────────────────────────────────────────────────────┘

class ue_youtube
{
    use \ue\debug;

    private $options;

    private $data;

    private $results;

    private $client;

    private $service;

    public function set_options($options)
    {
        $this->options = $options;
    }

    public function set_data($data)
    {
        $this->data = $data;
    }


    public function run()
    {
        $this->set_client();
        if ($this->noClient()){ return; }
        $this->run_youtube_request();
    }


    private function set_client()
    {
        $client = new oauth_youtube_client();
        $client->run();
        $this->client = $client->get_client();
    }


    /**
     * Get a new YouTube Object.
     * 
     * Services are called through queries to service specific objects. 
     * These are created by constructing the service object, and passing an 
     * instance of Google_Client to it. Google_Client contains the IO, authentication 
     * and other classes required by the service to function, and the service informs 
     * the client which scopes it uses to provide a default when authenticating a user.
     */
    private function run_youtube_request()
    {

        $this->service = new \Google_Service_YouTube($this->client);

        /**
         * Each API provides resources and methods, usually in a chain. These can be 
         * accessed from the service object in the form $service->resource->method(args). 
         * Most method require some arguments, then accept a final parameter of an array 
         * containing optional parameters.
         */
        $queryParams = [
            'mine' => true
        ];

        $this->results = $this->service->channels->listChannels( 'snippet,contentDetails,statistics', $queryParams );

        $this->debug_update('export', $this->results);
    }


    /**
     * noTokens function
     *
     * Check to see if there are tokens.
     * 
     * @return void
     */
    private function noClient()
    {
        if ($this->client == null)
        {
            return true;
        }
        return false;
    }
}
