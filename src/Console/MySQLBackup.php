<?php

namespace OleAass\MySQLBackup\Console;

use Illuminate\Console\Command;

class MySQLBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oleaass:mysql:backup {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a backup of the MySQL database';

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
     * @return int
     */
    public function handle()
    {
        if (!function_exists('exec')) {
            return $this->error('The exec function is required to continue. Please check your PHP configuration!');
        }

        exec('which mysqldump', $output, $missingMysqldump);

        if ($missingMysqldump) {
            return $this->error('Please install mysqldump to continue!');
        }

        exec('which gzip', $output, $missingGzip);

        if ($missingGzip) {
            return $this->error('Please install gzip to continue');
        }

        $name = $this->option('name');

        $datetime = date('Ymd_His');
        $filename = $name ?? "database-{$datetime}";
        $path = storage_path("app/backup");
        $fullpath = "{$path}/$filename.sql.gz";

        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $database = config('database.connections.mysql.database');

        $command = "mkdir -p {$path} && mysqldump --user={$username} --password={$password} --host={$host} {$database} --no-tablespaces | gzip > {$fullpath}";

        $output = null;
        $result_code = null;

        $ret = exec($command, $output, $result_code);

        if ($ret === false) {
            return $this->error('Unable to dump database');
        }

        return $this->info("Database dumped successfully");
    }
}
