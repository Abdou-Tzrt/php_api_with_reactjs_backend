<?php
// autoloading classes
require_once __DIR__.'/vendor/autoload.php';
// require_once __DIR__.'/src/config/__init.php';
// require_once __DIR__.'/src/routes/index.php';

//fix cross origin blocked
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}



// use App\Database\Database as DB;
use App\Controllers\EventController as EventController;
use App\Controllers\CategoryController as CategoryController;
use App\Controllers\UserController as UserController;

$event = new EventController;
$category = new CategoryController;
$user = new UserController;


// ------------------------  METHODE 1 ----------------

//break url to parts
$segments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if($_SERVER['REQUEST_METHOD'] === 'GET' && empty($segments[1])) {
    $event->index();
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'GET' && $segments[1] === 'events' && empty($segments[2])) {
    $event->index();
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'GET' && $segments[1] === 'event' && isset($segments[2])) {
    $event->show($segments[2]);
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'GET' && $segments[1] === 'events' && isset($segments[2]) && $segments[2] === 'category' && isset($segments[3])) {
    $event->eventsByCategory($segments[3]);
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'GET' && $segments[1] === 'categories' && empty($segments[2])) {
    $category->index();
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'POST' && $segments[1] === 'register' && empty($segments[2])) {
    $request = (array) json_decode(file_get_contents('php://input'), true);
    $user->register($request);
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'POST' && $segments[1] === 'login' && empty($segments[2])) {
    $request = (array) json_decode(file_get_contents('php://input'), true);
    $user->login($request);
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'POST' && $segments[1] === 'logout' && empty($segments[2])) {
    $request = (array) json_decode(file_get_contents('php://input'), true);
    $request['api_key'] = $_SERVER['HTTP_X_API_KEY'] ?? '';
    $user->logout($request);
    exit;
}else {
    http_response_code(404);
    echo json_encode([
        'error'     => true,
        'message'   => ' Error 404 !! The page you are looking for dones not exist.'
    ]);
}




// ------------------------  METHODE 2 ----------------

// $routes = [];

// route('/',  function (){
//     echo 'Home page';
// });

// route('/login', function (){
//     echo 'Login page';
// });

// route('/about-us', function (){
//     echo 'About-Us page';
// });

// route('/404', function (){
//     echo 'Page Not Found';
// });

// function route(string $path, callable $callback) {
//     global $routes;
//     $routes[$path] = $callback;

// }

// run();

// function run() {
//     global $routes;
//     $uri = $_SERVER['REQUEST_URI'];
//     $found = false;

//     foreach ($routes as $path => $callback){
//         if ($path !== $uri) continue;
//         $callback();
//         $found = true;
//     }
//     if(!$found){
//         $notFoundCallback = $routes['/404'];
//         $notFoundCallback();
//     }
// }



// // ------------------------  METHODE 3 With Routes/index/php ----------------

// /**
//  * 
//  * Instance of router
//  * 
//  */
// $router = new Router();

// /**
//  * 
//  * handle / route
//  */
// $router->get('/', [EventController::class, 'index']);

// /**
//  * 
//  * handle / contact
//  */
// $router->get('/contact', 'contact.html');
