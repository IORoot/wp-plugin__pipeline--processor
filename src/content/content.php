<?php

namespace ue;

class content
{

    use utils;   
    use debug;

    public $options;

    public $results;

    public $class_object;

    public function set_options($options)
    {
        $this->options = $options;
    }

    public function set_collection($collection)
    {
        return;
    }


    public function run()
    {
        if ($this::is_disabled($this->options['ue_job_content_id'], 'content')){ return; }
        $this->debug_clear('content');
        $this->instantiate_class();
        $this->set_args();
        $this->execute();
        return $this->results;
    }

    

    public function instantiate_class()
    {
        $this->class_object = $this::class_instantiate('ue\content', $this->input_type());
        return;

    }




    public function set_args()
    {
        if ($this->input_type() == 'query')
        {
            $this->class_object->set_args($this->get_query());
            return;
        }

        $this->class_object->set_args($this->get_post());
    }



    public function execute()
    {
        $this->results = $this->class_object->run();
        $this->debug_update('content', $this->results);
        
    }



    public function input_type()
    {
        return $this->options['ue_job_content_id']['ue_content_input'];
    }

    public function get_query()
    {
        return $this->options['ue_job_content_id']['ue_content_query'];
    }  

    public function get_post()
    {
        return $this->options['ue_job_content_id']['ue_content_posts'];
    }  

    
}
