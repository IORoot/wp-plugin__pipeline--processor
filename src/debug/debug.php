<?php

namespace ue;

// reporting
trait debug
{

    use \ue\utils;



    public $acf_group;

    public $acf_textarea;

    public $message;

    public $namespace = "ue";

    public $char_limit = 10000;




    public function debug($section, $message){

        $this->message = $message;

        $this->section = $section;

        $this->clear();

        $this->set_acf_group();

        $this->set_acf_textarea();

        $this->get_character_limit();

        $this->set_record_count();

        $this->update();

        
    }



    
    public function set_acf_group()
    {
        $this->acf_group = $this->namespace . '_' . $this->section . '_debug_group';
    }

    public function set_acf_textarea()
    {
        $this->acf_textarea = $this->acf_group . '_' . $this->namespace . '_' . $this->section . '_debug';
    }

    public function get_character_limit()
    {
        $field = $this->acf_textarea . '_limit';
        $this->char_limit = intval(get_field($field, 'options'));
    }




    public function clear()
    {
        return update_field( $this->acf_textarea, '', 'option');
    }



    public function update()
    {

        $trim_length = $this->char_limit;
        $value = $this->message;
        $field = $this->acf_textarea;
        
        $value = $this::to_pretty_JSON($value);

        $this->set_character_count($value);
        $this->set_line_count($value);

        if ($trim_length != 0){
            $trimmed_string = substr($value, 0, $trim_length);
        }

        $update = update_field($field, $trimmed_string, 'option');

    }



    public function set_character_count($string)
    {
        $field = $this->acf_textarea . '_characters';

        $count = strlen($string);

        return update_field( $field, $count, 'option');
    }


    public function set_record_count()
    {
        $field = $this->acf_textarea . '_records';

        $count = count($this->message);

        return update_field( $field, $count, 'option');
    }


    public function set_line_count($string)
    {
        $field = $this->acf_textarea . '_lines';

        $count = substr_count( $string, "\n" );

        return update_field( $field, $count, 'option');
    }


    

}