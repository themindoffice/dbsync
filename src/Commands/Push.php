<?php

namespace TheMindOffice\DBSync\Commands;

use Illuminate\Console\Command;

class Push extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:push {env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push the database to the selected environment from local';

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

    }
}
