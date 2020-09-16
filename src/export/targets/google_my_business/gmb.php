<?php

// namespace ue\exporter;

class ue_google_my_business
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
        $this->run_gmb_request();
    }



//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                                                                         │░
//  │                                                                         │░
//  │                                 PRIVATE                                 │░
//  │                                                                         │░
//  │                                                                         │░
//  └─────────────────────────────────────────────────────────────────────────┘░
//   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░


    private function set_client()
    {
        $client = new oauth_gmb_client();
        $client->run();
        $this->client = $client->get_client();
    }


    /**
     * Get a new gmb Object.
     * 
     * Services are called through queries to service specific objects. 
     * These are created by constructing the service object, and passing an 
     * instance of Google_Client to it. Google_Client contains the IO, authentication 
     * and other classes required by the service to function, and the service informs 
     * the client which scopes it uses to provide a default when authenticating a user.
     */
    private function run_gmb_request()
    {
        $this->service = new \Google_Service_MyBusiness($this->client);

        /**
         * Each API provides resources and methods, usually in a chain. These can be 
         * accessed from the service object in the form $service->resource->method(args). 
         * Most method require some arguments, then accept a final parameter of an array 
         * containing optional parameters.
         */
        // $this->get_account_locations();
        $this->get_location_localposts();
        // $this->create_local_post();
        
        
    }

    /**
     * List all location details for account ID
     * 
     * LondonParkour Account = 'accounts/106324301700393434193'
    */
    private function get_account_locations()
    {
        $account = 'accounts/106324301700393434193';
        $this->results = $this->service->accounts_locations->listAccountsLocations($account);
        $this->debug('export', $this->results);
    }


    /**
     * List all LocalPosts for specific location.
     * 
     * LondonParkour Location = 'accounts/106324301700393434193/locations/13389130540797665003'
     */
    private function get_location_localposts()
    {
        $location = 'accounts/106324301700393434193/locations/13389130540797665003';
        $this->results = $this->service->accounts_locations_localPosts->listAccountsLocationsLocalPosts($location);
        $this->debug('export', $this->results);
    }



    /**
     * create_local_post function
     * 
     * Simple example of creating a test Call-To-Action Post.
     *
     * @return void
     */
    private function create_local_post()
    {
        $location = 'accounts/106324301700393434193/locations/13389130540797665003';

        $this->CTA = new \Google_Service_MyBusiness_CallToAction();
        $this->CTA->setActionType('LEARN_MORE');
        $this->CTA->setUrl('https://londonparkour.com');

        $this->media = new \Google_Service_MyBusiness_MediaItem();
        $this->media->setMediaFormat('PHOTO');
        $this->media->setSourceUrl('https://londonparkour.com/wp-content/uploads/2020/07/Discovery.jpg');

        $this->localPost = new \Google_Service_MyBusiness_LocalPost();
        $this->localPost->setSummary('Test Local Post');
        $this->localPost->setLanguageCode('en-GB');
        $this->localPost->setCallToAction($this->CTA);
        $this->localPost->setMedia($this->media);

        $this->result = $this->service->accounts_locations_localPosts->create($location, $this->localPost);

        $this->debug('export', $this->results);
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
