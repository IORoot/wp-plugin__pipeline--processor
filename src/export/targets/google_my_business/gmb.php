<?php

// namespace ue\exporter;

class ue_google_my_business
{
    
    use \ue\debug;
    
    private $options;

    private $data;

    private $results;

    private $client;

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
        $this->do_requests();
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




    private function do_requests()
    {
        foreach ($this->options["ue_cta_universal_exporter_google_my_business_posts"] as $this->request_type)
        {
            $this->run_gmb_request();
        }
    }

    private function run_gmb_request()
    {
        $request_name = '\\ue\\exporter\\gmb\\' . $this->request_type['acf_fc_layout'];
        $this->request = new $request_name;
        $this->request->set_options($this->request_type);
        $this->request->set_data($this->data);
        $this->request->set_client($this->client);
        $this->request->run();
        $this->results[] = $this->request->get_result();
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


            
    // /**
    //  * List all location details for account ID
    //  * 
    //  * LondonParkour Account = 'accounts/106324301700393434193'
    // */
    // private function get_account_locations()
    // {
    //     $account = 'accounts/106324301700393434193';
    //     $this->results = $this->service->accounts_locations->listAccountsLocations($account);
    //     $this->debug('export', $this->results);
    // }


    // /**
    //  * List all LocalPosts for specific location.
    //  * 
    //  * LondonParkour Location = 'accounts/106324301700393434193/locations/13389130540797665003'
    //  */
    // private function get_location_localposts()
    // {
    //     $location = 'accounts/106324301700393434193/locations/13389130540797665003';
    //     $this->results = $this->service->accounts_locations_localPosts->listAccountsLocationsLocalPosts($location);
    //     $this->debug('export', $this->results);
    // }

    
}
