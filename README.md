# MySQL backup for Laravel artisan

Simple package which allows you to easily make a backup of you MySQL database
using artisan command

## Installation

```
$ composer require oleaass/laravel-mysql-backup
```

## Usage

### Default usage

This will create a file named database-Ymd_His.sql.gz in `storage_path('app/backup')`

```
$ php artisan oleaass:mysql:backup
```

### Custom name

```
$ php artisan oleaass:mysql:backup --name=latestdb
```
