<?php

namespace TheMindOffice\DBSync\Commands;

use Doctrine\DBAL\Driver\PDOConnection;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use TheMindOffice\DBSync\Connector;

class Pull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:pull {env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull the database from the selected environment to local';

    /**
     * The database connection
     *
     * @var PDOConnection
     */
    public $env;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->connector = new Connector($this);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->connector->select($this->argument('env'))) {
            return;
        };

        $this->info('Creating database connection');
        $bar = $this->output->createProgressBar(4);

        $bar->advance();
        $file = $this->connector->dump($bar);

        $this->connector->load($file, $bar);
        $bar->advance();

        $this->comment('Done?');
    }
}
