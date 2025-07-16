<?php
// autoloading classes
require_once __DIR__.'/vendor/autoload.php';


use App\Database\Database as DB;

$con = new DB();

$con->connect();

