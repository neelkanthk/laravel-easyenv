<?php

namespace Neelkanth\Laravel\EasyEnv\Console\Commands;

use Neelkanth\Laravel\EasyEnv\Console\Commands\EasyEnvCommand;

class AddEnv extends EasyEnvCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyenv:add {env} {path} {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new environment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setEnv();
        $this->setPath();
        $this->setFile();

        $existingConfig = config("easyenv");
        if (is_null($existingConfig)) {
            $this->showConfigFileMissingError();
        } else if (!empty($this->getEnv()) && !empty($this->getPath())) {
            $env = $this->getEnv();
            $path = $this->getPath();
            $file = $this->getFile();
            if ((!in_array($env, array_keys($existingConfig["environments"])) && empty($existingConfig["environments"][$env]["path"]) && empty($existingConfig["environments"][$env]["file"]))) {
                $existingConfig["environments"][$env]["path"] = $path;
                $existingConfig["environments"][$env]["file"] = $file;
                $newConfig = var_export($existingConfig, true);
                $this->updateConfigFile($newConfig);
                $this->info("Done");
            } else {
                $this->info("\nThe environment: $env already exists having path: " . $existingConfig['environments'][$env]["path"]);
            }
        }
    }
}
