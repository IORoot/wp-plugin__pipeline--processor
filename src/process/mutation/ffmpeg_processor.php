<?php

namespace ue\mutation;

use ue\interfaces\mutationInterface;

class ffmpeg_processor implements mutationInterface
{
    use \ue\utils;
    use \ue\debug;

    public $description =   "";

    public $parameters = "";

    public $input;

    public $config;

    public $results;

    public $input_string = '';


    
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
        // Is FFMpeg installed?
        $this->is_ffmpeg_installed();
        if (empty($this->ffmpeg)) {
            $this->results = false;
            return;
        }

        // Start processing each record.
        $this->process_collection();

        // cleanup.
        $this->delete_concat_file();

        // return result.
        return $this->results;
    }


    public function out_collection()
    {
        return $this->out();
    }


    private function process_collection()
    {

        if (empty($this->config['ffmpeg_steps'])){ return; }
        
        foreach ($this->config['ffmpeg_steps'] as $this->step_key => $this->step_value) {

            if ($this->step_value['enabled'] == false) {
                continue;
            }

            $this->set_directories();
            $this->match_upload_dir();
            $this->match_dates();
            $this->match_timestamps();
            $this->match_concat_file();
            $this->match_inputs_line();
            $this->build_ffmpeg_command();
            $this->run_ffmpeg();    
            $this->output_file_in_results();
        }
    }



    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                            SETUP DIRECTORIES                            │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    /**
     * Sets: 
     *      upload_dir, 
     *      files_in_dir 
     *      concat_file
     */
    private function set_directories()
    {
        // get the upload directory.
        $upload_dir = wp_get_upload_dir();
        $this->upload_dir = $upload_dir['path'];

        // get all files in directory.
        $this->files_in_dir = scandir($this->upload_dir);

        // Remove images
        foreach ($this->files_in_dir as $key => $file)
        {
            // remove .DS_Store
            if (preg_match('/DS_Store/', $file) == 1)
            {
                unset($this->files_in_dir[$key]);
            }

            // Remove anything not a video file.
            if (preg_match('/[mp4|flv|mov|avi|webm|mkv]$/', $file) == 1)
            {
                continue;
            }
            
            unset($this->files_in_dir[$key]);
        }

        // concat file to create.
        $this->concat_file = $this->upload_dir . '/concat_file.txt';
    }




    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                           MATCH FILE INPUTS                             │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    /**
     * create_concat_file
     *
     * Creates a concat_file.txt with a list of all input videos.
     * Then makes this file the input to the ffmpeg command.
     *
     * @return void
     */
    private function match_concat_file()
    {
        if (strpos($this->step_value['ffmpeg_arguments'], '$concat_file')  === false) {
            return;
        }

        foreach ($this->config['collection'] as $record) {

            // get the filename for this record.
            $record_field = explode('->', $this->config['field_key']);
            $filename = $record;
            foreach ($record_field as $location) {
                $filename = $filename[$location];
            }

            // find file and extension in filelist array
            $regex = '/^'.$filename.'[\s|\S].*/';
            $file_and_ext = preg_grep($regex, $this->files_in_dir);
            $file_and_ext = array_pop(array_reverse($file_and_ext));
            
            // String to add to file.
            $string_to_write = 'file \'' . $this->upload_dir . '/' .$file_and_ext . '\'' .PHP_EOL;
            $this->filelist[] = $this->upload_dir . '/' .$file_and_ext;

            // write to file.
            file_put_contents($this->concat_file, $string_to_write, FILE_APPEND);
        }

        // Replace string with real location of concat file.
        $this->step_value['ffmpeg_arguments'] = str_replace('$concat_file', $this->concat_file, $this->step_value['ffmpeg_arguments']);
    }





    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                          MATCH & REPLACE STUFF                          │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    /**
     * check_for_inputs_line
     *
     * replaces $inputs for `-i input1.mp4 -i input2.mp4...`
     *
     * @return void
     */
    private function match_inputs_line()
    {
        if (strpos($this->step_value['ffmpeg_arguments'], '$inputs') === false) {
            return;
        }

        foreach ($this->config['collection'] as $record) {

            // get the filename for this record.
            $record_field = explode('->', $this->config['field_key']);
            $filename = $record;
            foreach ($record_field as $location) {
                $filename = $filename[$location];
            }

            // find file and extension in filelist array
            $regex = '/^'.$filename.'[\s|\S].*/';
            $file_and_ext = preg_grep($regex, $this->files_in_dir);
            $file_and_ext = array_pop(array_reverse($file_and_ext));
            
            // String to add to file.
            $this->input_string .= ' -i ' . $this->upload_dir . '/' .$file_and_ext . ' ';
            $this->filelist[] = $this->upload_dir . '/' .$file_and_ext;
        }

        // Replace string with real location of concat file.
        $this->step_value['ffmpeg_arguments'] = str_replace('$inputs', $this->input_string, $this->step_value['ffmpeg_arguments']);
    }


    /**
     * Search and replace the $upload_dir string.
     */
    private function match_upload_dir()
    {
        $this->step_value['ffmpeg_arguments'] = str_replace('$upload_dir', $this->upload_dir, $this->step_value['ffmpeg_arguments']);
    }

    /**
     * Search and replace the $date string
     */
    private function match_dates()
    {
        $this->step_value['ffmpeg_arguments'] = str_replace('$date', date('Ymd_Hms'), $this->step_value['ffmpeg_arguments']);
    }

    /**
     * Search and replace the $timestamp string
     */
    private function match_timestamps()
    {
        $this->step_value['ffmpeg_arguments'] = str_replace('$timestamp', date('U'), $this->step_value['ffmpeg_arguments']);
    }


    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                             DELETE STUFF                                │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘
    private function delete_concat_file()
    {
        unlink($this->concat_file);
    }


    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                                   CHECKS                                │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    private function is_ffmpeg_installed()
    {
        $this->ffmpeg = trim(shell_exec('which ffmpeg'));
    }


    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                              BUILD & RUN                                │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘

    private function build_ffmpeg_command()
    {
        $this->command = $this->ffmpeg . ' ';
        $this->command .= $this->step_value['ffmpeg_arguments'];
        // $this->command .= ' 2>&1 ';
    }


    private function run_ffmpeg()
    {
        exec($this->command, $output_of_command, $return_var);
        $this::debug_update('process', 'COMMAND:' . $this->command);
        $this::debug_update('process', 'OUTPUT:' . $output_of_command);
        $this::debug_update('process', 'RETURN_VARS:' . $return_var);
        $this->results = $this->filelist;
    }


    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                                                                         │
    // │                           OUTPUT FILE ADDITIONS                         │
    // │                                                                         │
    // └─────────────────────────────────────────────────────────────────────────┘
    private function output_file_in_results()
    {
        $regex = '/\s(\S*\.\S{3,4})$/s'; // File at the end with 3 character extension.
        preg_match($regex, $this->command, $match);
        $this->results['output_file'] = trim($match[1]);
    }
}
