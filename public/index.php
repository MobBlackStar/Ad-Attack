<?php
// TEAM: Welcome to the Router! This is our building's Receptionist.
// Moataz: Great job on the BASE_URL fix below, it solves all our path issues!

require_once '../vendor/autoload.php';
session_start();

// --- DYNAMIC PATH CONFIG ---
$base = 'http://' . $_SERVER['HTTP_HOST'];
$folder = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $base . $folder);
// TEAM: Moataz ,I'm adding a GPS Bookmark for our Views folder. 
// This makes sure 'require' always finds the files!
define('VIEW_PATH', dirname(__DIR__) . '/app/Views');
// ---------------------------

$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

$controllerName = ucfirst($urlParts[0]) . 'Controller';
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';
$controllerClass = "App\\Controllers\\" . $controllerName;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $methodName)) {
        // TEAM: We remove the names and pass the remaining pieces (like ID) to the Manager.
        unset($urlParts[0]); 
        unset($urlParts[1]); 
        call_user_func_array([$controller, $methodName], $urlParts);
    } else {
        echo "Manager found, but the action '$methodName' is missing.";
    }
} else {
    echo "<h1>404 - Receptionist cannot find $controllerName</h1>";
}