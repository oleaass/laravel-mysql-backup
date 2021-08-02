<?php

namespace OleAass\MySQLBackup;

use Illuminate\Support\ServiceProvider;
use OleAass\MySQLBackup\Console\MySQLBackup;

class MySQLBackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MySQLBackup::class
            ]);
        }
    }
}
