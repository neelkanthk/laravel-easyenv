<?php

namespace Neelkanth\Laravel\EasyEnv;

class EasyEnv
{

    public static function file()
    {
        //Get enabled env file
        $envFile = "";
        if (self::envFileExists()) {
            $config = require config_path('easyenv.php');
            $envFile = !empty($config["enabled"]) ? $config["environments"][$config["enabled"]]["file"] : "";
        }
        return $envFile;
    }

    public static function path()
    {
        //Get enabled env file path
        $envPath = "";
        if (self::envFileExists()) {
            $config = require config_path('easyenv.php');
            $envPath = !empty($config["enabled"]) ? $config["environments"][$config["enabled"]]["path"] : "";
        }
        return $envPath;
    }

    public static function envFileExists()
    {
        $config = require config_path('easyenv.php');
        $envPath = !empty($config["enabled"]) ? $config["environments"][$config["enabled"]]["path"] : "";
        $envFile = !empty($config["enabled"]) ? $config["environments"][$config["enabled"]]["file"] : "";
        return file_exists($envPath . $envFile);
    }

}
