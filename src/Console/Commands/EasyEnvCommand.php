<?php

namespace Neelkanth\Laravel\EasyEnv\Console\Commands;

use Illuminate\Console\Command;

class EasyEnvCommand extends Command
{
    private $env;
    private $path;
    private $file;
    private $config;

    public function __construct()
    {
        parent::__construct();
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function getPath()
    {
        return $this->path;
    }
    
    public function getFile()
    {
        return $this->file;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setEnv()
    {
        $this->env = $this->argument("env");
    }

    public function setPath()
    {
        $this->path = $this->argument("path");
    }
    
    public function setFile()
    {
        $this->file = $this->argument("file");
    }

    /**
     * Error message to show when config file is not found.
     *
     * @return void
     */
    public function showConfigFileMissingError()
    {
        $this->error("\nCould not load the config/easyenv.php file.");
        $this->line("\nPlease make sure that you have published the package's config file using the command mentioned below.");
        $this->info('php artisan vendor:publish --provider="Neelkanth\Laravel\EasyEnv\Providers\EasyEnvServiceProvider" --tag="config" --force');
        $this->line("\nStill facing the issue? Kindly report it at https://github.com/neelkanthk/laravel-easyenv/issues.");
    }

    /**
     * Write updated configuration.
     * 
     * @return void
     */
    public function updateConfigFile($newConfig)
    {
        $newConfigFileContent = '<?php return ' . $newConfig . ';';
        file_put_contents(config_path('easyenv.php'), $newConfigFileContent);
    }
}
