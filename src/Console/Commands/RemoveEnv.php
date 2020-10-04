<?php

namespace Neelkanth\Laravel\EasyEnv\Console\Commands;

use Neelkanth\Laravel\EasyEnv\Console\Commands\EasyEnvCommand;

class RemoveEnv extends EasyEnvCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyenv:remove {env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an environment.';

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
            $environments = config("easyenv.environments");
            $enabled = config("easyenv.enabled");
            $removeFlag = true;
            if (!(in_array($env, array_keys($environments)))) {
                $this->error("\nCould not find the provided environment in config/easyenv.php");
                $removeFlag = false;
            } else if ($env == $enabled) {
                $this->warn("\nAttention: You have choosen to remove an enabled environment. This will cause the application to look for .env file at: " . base_path('.env'));
                $userInput = $this->confirm("If you want to proceed type 'y' or 'yes' and press Enter.");
                if ($userInput) {
                    $removeFlag = true;
                    $existingConfig["enabled"] = "";
                } else {
                    $removeFlag = false;
                }
            }
            if ($removeFlag) {
                unset($existingConfig["environments"][$env]);
                $newConfig = var_export($existingConfig, true);
                $this->updateConfigFile($newConfig);
                $this->info("Done");
            }
        }
        $this->line("");
    }

}
