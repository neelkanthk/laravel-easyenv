<?php

namespace Neelkanth\Laravel\EasyEnv\Console\Commands;

use Neelkanth\Laravel\EasyEnv\Console\Commands\EasyEnvCommand;

class EnableEnv extends EasyEnvCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyenv:enable {env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enabled an environment.';

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
        if (is_null(config("easyenv"))) {
            $this->showConfigFileMissingError();
        } else {
            $env = $this->getEnv();
            $existingConfig = config("easyenv");
            $environments = $existingConfig["environments"];
            if ($env == "default" || (in_array($env, array_keys($environments)) && !empty($environments[$env]))) {
                $existingConfig["enabled"] = $env;
                $newConfig = var_export($existingConfig, true);
                $this->updateConfigFile($newConfig);
                $this->info("Done");
            } else {
                $this->warn("\nThe provided environment is not added in the list.");
                $this->info("\nLet's add one using 'php artisan easyenv:add {env} {path} {file}'");
            }
        }
    }
}
