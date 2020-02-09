<?php

namespace memfisfa\Finac\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fa:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '- Installer FA Module by MeMFIS Developer -';

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
        $this->copyright();

        $this->warn('Run This Command After Running memfis:rebuild');
        if ($this->confirm('Continue?')) {
            if ($this->confirm('Publish Asset?')) {
                $this->info('[START] Publishing Assets..........');
                $this->callSilent('vendor:publish', ['--force' => true, '--tag' => 'assetsfa']);
                $this->info('[DONE] Publishing Assets..........');
            }
            if ($this->confirm('Install/Seed Initial Data?')) {
                if ($this->confirm('You Are in Production Mode, Are You Sure?')) {
                    $this->info('[START] Install Initial Data..........');
                    $this->callSilent('db:seed', ['--class' => "memfisfa\\Finac\\Database\\Seeds\\DatabaseSeeder"]);
                    $this->info('[DONE] Install Initial Data.');
                }
            }
        }
    }


    /**
     * Command's copyright'
     *
     * @return mixed
     */
    protected function copyright()
    {
        $this->line('');
        $this->line('"fa: Install" artisan command');
        $this->line('Version 0.1 by MeMFIS');
    }
}
