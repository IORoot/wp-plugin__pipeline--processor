<?php

namespace ue\exporter\youtube;

class insert_video
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

    public function set_client($client)
    {
        $this->client = $client;
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
    public function run()
    {
        if ($this->isDisabled()){ return; }
        $this->parse_moustaches();
        $this->insert_video();
        $this->debug_update('export', $this->results);
    }
    

    
    public function get_result()
    {
        return $this->results;
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
     * parse_moustaches
     * 
     * Substitute any moustaches for real values.
     * Split into two parts {{post_type:field}}
     * Post_type = post, meta, image
     * Field = Any found field.
     *
     * @return void
     */
    private function parse_moustaches()
    {
        foreach($this->data as $posttype => $postid)
        {
            $parse = new \ue\parse\replace_moustaches_in_array($postid, $this->options);
            $this->options = $parse->get_results();
        }
        
    }

    /**
     * Each API provides resources and methods, usually in a chain. These can be 
     * accessed from the service object in the form $service->resource->method(args). 
     * Most method require some arguments, then accept a final parameter of an array 
     * containing optional parameters.
     */
    private function insert_video()
    {
        
        /**
         * Get a new YouTube Object.
         * 
         * Services are called through queries to service specific objects. 
         * These are created by constructing the service object, and passing an 
         * instance of Google_Client to it. Google_Client contains the IO, authentication 
         * and other classes required by the service to function, and the service informs 
         * the client which scopes it uses to provide a default when authenticating a user.
         */
        $this->service = new \Google_Service_YouTube($this->client);

        /**
         * Each API provides resources and methods, usually in a chain. These can be 
         * accessed from the service object in the form $service->resource->method(args). 
         * Most method require some arguments, then accept a final parameter of an array 
         * containing optional parameters.
         */
        try {

            $this->results = $this->service->channels->listChannels( 
                'snippet,contentDetails,statistics', 
                [
                    'mine' => true
                ]
            );
        } 
        catch (\Google_Service_Exception $e) {
            $this->results = 'Caught \Google_Service_Exception: ' .  print_r($e->getMessage(), true) . "\n" . 'Request was: ' . print_r($this->localPost,true);
        }
        catch (\Exception $e) {
            $this->results = 'Caught \exception: ' .  print_r($e->getMessage(),true) . "\n" . 'Request was: ' . print_r($this->localPost, true);
        }

    }

    private function isDisabled()
    {
        if ($this->options['enabled'] == false)
        {
            return true;
        }
        return false;
    }
}