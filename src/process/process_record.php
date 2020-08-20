<?php

namespace ue;


class process_record
{

    public $prefix = 'ue_mutation_';

    public $config;

    public $record;

    public $results;

    public $_field_key;
    public $_field_value;



    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_record($record)
    {
        $this->record = $record;
    }



    public function run()
    {
        $this->loop_through_record();
        
        return $this->results;
    }



    public function loop_through_record()
    {
        foreach ($this->record as $this->_field_key => $this->_field_value) {

            // Skip if field doesn't need changing.
            if (!$this->is_field_in_mutation_list()) {
                continue;
            }

            $this->run_mutations_on_field();

        }
    }



    public function run_mutations_on_field()
    {

        $field = new process_field;

        $field->set_data([
            'key' => $this->_field_key,
            'value' => $this->_field_value
        ]);      

        $field->set_config($this->config);

        $return_data = $field->run();          

        $this->results[$return_data['key']] = $return_data['value'];
    }






    public function is_field_in_mutation_list()
    {
        foreach($this->config as $mutation)
        {
            if ($mutation[$this->prefix . 'input'] == $this->_field_key)
            {
                return true;
            }
        }

        return false;
    }
}
