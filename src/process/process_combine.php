<?php

namespace ue;


class process_combine
{

    public $config;

    public $combine_instance;

    public $data;

    public $results = [];


    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_data($data)
    {
        $this->data = $data;
    }



    public function run()
    {
        $this->process_each_combine();
        return $this->results;
    }


    public function process_each_combine()
    {
        foreach ($this->config as $this->combine_instance)
        {
            $result = $this->combine();

            $this->results = array_merge($this->results, $result);
        }
    }

    public function combine()
    {
        $combine_type = '\\ue\\combine\\' . $this->combine_instance['ue_mutation_combine'];

        $combine = new $combine_type;
        $combine->config($this->combine_instance['ue_mutation_moustache']);
        $combine->in($this->data);
        return $combine->out();
    }

}
