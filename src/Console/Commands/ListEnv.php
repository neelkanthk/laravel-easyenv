<?php

namespace Neelkanth\Laravel\EasyEnv\Console\Commands;

use Neelkanth\Laravel\EasyEnv\Console\Commands\EasyEnvCommand;

class ListEnv extends EasyEnvCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyenv:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show a list of all the environments and their details.';

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
            $this->configFileMissingMessages();
        } else {
            $environments = config("easyenv.environments");
            $enabled = config("easyenv.enabled");
            $headers = ["Environment", "Status", "Path", "File"];
            $rows = array();
            if (!empty($environments)) {
                foreach ($environments as $environment => $detail) {
                    array_push($rows, [
                        "environment" => $environment,
                        "enabled" => ($environment == $enabled) ? "Enabled" : "",
                        "path" => $detail["path"],
                        "file" => $detail["file"]
                    ]);
                }
                $this->line("");
                $this->table($headers, $rows);
                if (empty($enabled)) {
                    $this->warn("\nAttention: None of the environments are enabled. The default .env file of Laravel will be used.");
                    $this->info("\nLet's enable one using 'php artisan easyenv:enable {env}'");
                }
            } else {
                $this->warn("\nAttention: No environments are added. The default .env file of Laravel will be used.");
                $this->info("\nLet's add one using 'php artisan easyenv:add {env} {path} {file}'");
            }
        }
        $this->line("");
    }
}
