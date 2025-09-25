<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConfigureApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:configure {databaseName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the initial configuration and database creation, must provide the ' . 
    'database name in first argument.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create the database to run the proper migration.
        $databaseName = $this->argument('databaseName');
        $createDB = DB::connection('mysql_initial')
                        ->statement("CREATE DATABASE IF NOT EXISTS $databaseName CHARACTER SET utf8mb4 " . 
                            "COLLATE utf8mb4_unicode_ci");
        if ($createDB == 1) {
            // Run the migrations command
            $this->call('migrate');
            // Run the seeders command
            $this->call('db:seed', [
                '--class' => "DatabaseSeeder"
            ]);
            $this->info("The application was configured successfully.");
        } else {
            $this->info("The database name already exists, choose another.");
        }
    }
}
