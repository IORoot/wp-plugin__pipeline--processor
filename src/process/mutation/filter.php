<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class filter implements mutationInterface
{
    
    use \ue\utils;

    public $description = "Runs a Wordpress Filter. Requires an array with 'filter' and 'args'. 
    '{{field_key}}' = current input field.
    '{{field_value}}' = current input field result value.
    '{{record}}' = current record being processed.
    '{{collection}}' Entire result set from query";

    public $parameters = "
    [
        'filter' => 'genimage_get_filters',
        'args' => 
            [
                'corner_dots',
                '{{field_key}}',
                '{{field_value}}',
                '{{record}}',
                '{{collection}}',
            ]
    ]
    ";

    public $input;

    public $config;

    private $filter_name;
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
        $this->get_filter_name();
        $this->get_filter_args();
        $this->run_filter();

        return $this->filter_result;
    }



    private function get_filter_name()
    {
        if (isset($this->config['filter_name']))
        {
            $this->filter_name = $this->config['filter_name'];
        }
    }



    private function get_filter_args()
    {
        if (isset($this->config['filter_arguments']))
        {
            $this->filter_name = $this->config['filter_arguments'];
        }
    }



    private function run_filter()
    {
        if ($this->filter_name == null)
        {
            $this->filter_result = "No filter Name given.";
            return;
        }
        
        if ($this->filter_args == null)
        {
            $this->filter_result = "No filter Args given.";
            return;
        }

        $this->filter_result = apply_filters_ref_array($this->filter_name, $this->filter_args);

        return;
    }


}
