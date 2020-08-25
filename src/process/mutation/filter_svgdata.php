<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class filter_svgdata implements mutationInterface
{
    
    public $description = "Runs the GENIMAGE filter_svgdata Filter. Requires two arrays. filter_slug and collection 
    
    ";

    public $parameters = "
    [
        'filter_slug' => 'corner_dots',
        'collection' => '{{collection}}',
    ]
    ";

    public $input;

    public $config;


    private $filter_args;
    private $filter_result;
    
    public function config($config)
    {
        $this->config = $config;
        return;
    }

    public function in($input)
    {
        $this->input = $input;
    }

    public function out()
    {
        $this->get_filter_slug();
        $this->get_image_data();
        $this->run_filter();

        return $this->filter_result;
    }



    private function get_filter_slug()
    {
        if (!isset($this->config['filter_slug'])) {
            return;
        }

        $this->filter_args[0] = $this->config['filter_slug'];
    }


    private function get_image_data()
    {
        if (!isset($this->config['collection'])) {
            return;
        }

        foreach ($this->config['collection'] as $key => $record)
        {
            $image_group[$key] = $record['_wp_attachment_src'];
        }

        // Set the second argument to result.
        $this->filter_args[1] = $image_group;
        
    }



    private function run_filter()
    {
        $this->filter_result = apply_filters_ref_array('genimage_get_svgdata', $this->filter_args);
    }


}
