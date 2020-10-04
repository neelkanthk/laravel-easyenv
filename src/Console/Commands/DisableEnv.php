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
    protected $signature = 'easyenv:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable currently enabled environment.';

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
        if (is_null(config("easyenv"))) {
            $this->showConfigFileMissingError();
        } else {
            $this->warn("\nAttention: This will cause the application to look for .env file at: " . base_path('.env'));
            $userInput = $this->confirm("If you want to proceed type 'y' or 'yes' and press Enter.");
            if ($userInput) {
                $existingConfig = config("easyenv");
                $existingConfig["enabled"] = "";
                $newConfig = var_export($existingConfig, true);
                $this->updateConfigFile($newConfig);
                $this->info("Done");
            }
        }
    }
}
