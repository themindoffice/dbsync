<?php

namespace TheMindOffice\DBSync;

use Ifsnop\Mysqldump\Mysqldump;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Connector {

    private $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    private function config($key)
    {
        return config('dbsync.'.$this->command->env.'.'.$key);
    }

    public function select($env)
    {
        if ( empty(config('dbsync.'.$env) ) ) {
            $this->command->error('Environment '.$env.' is not configured');
//
            return false;
        }

        $this->command->env = $env;

        return true;
    }

    public function dump($bar)
    {
        $dump = new Mysqldump('mysql:host='.$this->config('host').';dbname='.$this->config('database'),
            $this->config('username'),
            $this->config('password'),
            [
                'lock-tables' => false
            ]
        );

        $filename = storage_path('dbsync/'.now()->format('d_m_Y-H_i_s').'.sql');

        $dump->start($filename);
        $bar->advance();

        return $filename;
    }

    public function load($dump, $bar)
    {
        $db = new \mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));

        $db->query('DROP DATABASE `'.env('DB_DATABASE').'`;');
        $db->query('CREATE DATABASE `'.env('DB_DATABASE').'`;');
        $db->query('USE `'.env('DB_DATABASE').'`;');
        $bar->advance();

        if (!$db->multi_query(File::get($dump))) {
            echo "Multi query failed: (" . $db->errno . ") " . $db->error;
        }

        $db->close();
    }
}
