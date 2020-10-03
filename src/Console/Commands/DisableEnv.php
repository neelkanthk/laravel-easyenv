<?php

namespace Neelkanth\Laravel\EasyEnv\Console\Commands;

use Neelkanth\Laravel\EasyEnv\Console\Commands\EasyEnvCommand;

class DisableEnv extends EasyEnvCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyenv:disable {env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable an enabled environment.';

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
            $enabledEnv = config("easyenv.enabled");
            $environments = $existingConfig["environments"];
            if ($env == $enabledEnv) {
                $existingConfig["enabled"] = "";
                $newConfig = var_export($existingConfig, true);
                $this->updateConfigFile($newConfig);
                $this->info("Done");
            } else {
                $this->warn("\nThe provided environment is not enabled.");
                $this->info("\nLet's enable it first using 'php artisan easyenv:enable {env}'");
            }
        }
    }
}
