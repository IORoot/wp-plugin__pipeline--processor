<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class filter implements mutationInterface
{
    
    use \ue\utils;

    public $description = "";

    public $parameters = "";

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

    public function out_collection()
    {
        return $this->out();
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
            $this->filter_args = $this->config['filter_arguments'];
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

        $this->filter_result[] = apply_filters_ref_array($this->filter_name, $this->filter_args);

        return;
    }


}
