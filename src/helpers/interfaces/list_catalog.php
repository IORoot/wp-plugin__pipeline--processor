<?php

namespace ue\interfaces;

trait list_catalog
{

    public static function list_catalog($folder, $type)
    {
        $catalog = null;

        $files = scandir(ANDYP_UE_PATH . '/src/' . $folder . '/' . $type);

        foreach ($files as $file){

            if ($file == '.' || $file == '..'){ continue; }

            $classname = '\\ue\\'.$type.'\\'.str_replace('.php', '', $file);
            $name = str_replace('.php', '', $file);
            $instance = new $classname;

            $catalog["${name}"]['name'] = $name;
            $catalog["${name}"]['classname'] = $classname;
            $catalog["${name}"]['file'] = $file;
            $catalog["${name}"]['description'] = $instance->description;
            $catalog["${name}"]['parameters'] = $instance->parameters;

        }

        return $catalog;
    }

}