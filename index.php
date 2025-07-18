<?php
// autoloading classes
require_once __DIR__.'/vendor/autoload.php';

use App\Database\Database as DB;
use App\Controllers\EventController as EventController;

$events = new EventController;

// $events->index();
// $events->show(1);
$events->eventsByCategory(1);

