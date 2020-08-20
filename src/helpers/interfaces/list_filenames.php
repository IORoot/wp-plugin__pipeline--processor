<?php

namespace ue\interfaces;

trait list_filenames
{

    public static function list_filenames($folder, $type)
    {
        $file_array = null;

        $files = scandir(ANDYP_UE_PATH . '/src/' . $folder . '/'. $type);

        foreach ($files as $file){
            $file = str_replace('.php', '', $file);
            $file_array["${file}"] = $file;
        }

        unset($file_array['.']);
        unset($file_array['..']);

        return $file_array;
    }

}