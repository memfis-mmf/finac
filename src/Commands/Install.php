<?php

namespace Directoryxx\Finac\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finac:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installer FA Module by directoryx';

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

        $this->warn('Run This Command After Running memfis:rebuild !!!');
        if ($this->confirm('Continue?')) {
            if ($this->confirm('Publishing asset?')) {
                $this->info('[START] Publishing asset..........');
                $this->callSilent('vendor:publish', ['--force' => true, '--tag' => 'assetsfa']);
                $this->info('[DONE ] Publishing asset..........');
            }
            if ($this->confirm('Install initial data?')) {
                $this->info('[START] Install initial data..........');
                $this->call('db:seed', ['--class' => "Directoryxx\\Finac\\Database\\Seeds\\DatabaseSeeder"]);
                $this->info('[DONE ] Install initial data.');
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
        $this->line('"Finac: Installer" artisan command');
        $this->line('version 0.1 by @directoryx');
    }
}
