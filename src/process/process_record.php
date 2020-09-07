<?php

namespace ue;

class process_record
{
    public $config;
    public $current_config;

    public $collection;

    public $record;
    public $smaller_record;

    public $field_key;
    public $field_value;

    public $result;

    public function set_config($config)
    {
        $this->config = $config;
    }

    public function set_record($record)
    {
        $this->record = $record;
    }

    /**
     * set_collection
     * 
     * Used for {{collection}} moustache
     *
     * @param array $collection
     * @return void
     */
    public function set_collection($collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        $this->remove_all_unneeded_fields();
        $this->loop_through_all_fields();
        return $this->result;
    }



    public function loop_through_all_fields()
    {
        foreach ($this->smaller_record as $this->field_key => $this->field_value)
        {
            $this->get_moustache_value();
            $this->process_field();
        }
        return;
    }


    public function get_moustache_value()
    {
        foreach ($this->config as $key => $value)
        {
            if ($value['ue_mutation_input'] == $this->field_key)
            {
                $this->moustache = $value['ue_mutation_moustache'];
            }
        }
    }

    /**
     * remove_all_unneeded_fields function
     *
     * This will only keep the fields in the record that there are
     * defined mutation rules for. This will become 
     * $this->smaller_record;
     * 
     * @return void
     */
    public function remove_all_unneeded_fields()
    {
        // check against each config field.
        foreach ($this->config as $this->current_config) {

            $exploded_field = explode('->', $this->current_config['ue_mutation_input']);
            $field_value = $this->record;

            foreach ($exploded_field as $field_depth)
            {
                $field_value = $field_value[$field_depth];
            }
            
            $smaller_record[$this->current_config['ue_mutation_input']] = $field_value;
        }
        $this->smaller_record = $smaller_record;
    }



    
    public function process_field()
    {
        $field = new process_field;
        $field->set_config($this->config);
        $field->set_field_key($this->field_key);
        $field->set_field_value($this->field_value);
        $field->set_record($this->record);          // used for {{record}} moustache
        $field->set_collection($this->collection);  // used for {{collection}} moustache
        $this->result[$this->moustache] = $field->run();
    }
}