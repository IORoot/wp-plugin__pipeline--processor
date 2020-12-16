<?php

/**
 * update_acf_options_field
 * 
 * Updates an option field data. Good for
 * updating select fields on the fly.
 * 
 * Example values
 * 
 * 1. SELECTS:
 * 
 * The value of a select field needs the following:
 * 
 * set_field('name_of_select_field);
 * 
 * set_value(
 *      'choices',
 *      [
 *          'choice1 value' => 'choice1 display value',
 *          'choice2 value' => 'choice2 display value',
 *      ]
 * )
 * 
 * 
 * 
 * 2. MESSAGES:
 * 
 * Message fields do NOT have a acf name (weird). So, supply the key instead.
 * 
 * set_field('field_1234567890');
 * 
 * set_value(
 *      'message',
 *      'This is what I <b>WANT</b> to add into the message field.'
 * )
 * 
 * 
 * 
 * https://support.advancedcustomfields.com/forums/topic/updating-field-settings-in-php/
 */
class update_acf_options_field
{

    private $field;

    private $fieldname;

    private $param_to_change;

    private $new_param_value;



    /**
     * set_field function
     * 
     * Accepts KEY or NAME
     *
     * @param [type] $fieldname
     * @return void
     */
    public function set_field($fieldname)
    { 
        $this->fieldname = $fieldname;
    }

    public function set_value($param_to_change, $new_param_value)
    {
        $this->param_to_change = $param_to_change;
        $this->new_param_value = $new_param_value;
    }

    public function run()
    {
        $this->convert_field_to_key();

        $this->get_acf_field_object();

        $this->change_field_param();
        
        $this->update_acf_field();

        return $this->result;
    }




    private function convert_field_to_key()
    {        
        if (strpos($this->fieldname, 'field_') === 0){ return; }

        $field = acf_get_field( $this->fieldname );

        if (!is_array($field)){ return; }
        
        $this->fieldname = $field['key'];
    }


    private function get_acf_field_object()
    {
        $this->field = get_field_object($this->fieldname);
    }

    private function change_field_param()
    {
        $param = $this->param_to_change;
        $this->field[$param] = $this->new_param_value;
    }

    private function update_acf_field()
    {
        $this->result = acf_update_field($this->field);
    }

}