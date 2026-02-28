<?php
// TEAM: Welcome to the Router hehehe, Think of this file as the "Receptionist" of our building Yusss.
// Nobody creates physical pages like 'login.php' anymore. 
// Every user comes here first, and this script directs them to the right Controller.
$_SESSION['user_id'] = 1; // For testing purposes, we pretend the user with ID 1 is logged in. Remove this in production!   
// 1. Give everyone the Phonebook (Composer Autoload) so classes find each other.
require_once '../vendor/autoload.php';

// 2. Start the Session (We need this later to remember who is logged in)
session_start();

// 3. Look at what the user typed in the URL. If they typed nothing, send them to 'home'.
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

// 4. Figure out which "Manager" (Controller) they want to talk to.
// Example: URL is '/login' -> We look for 'LoginController'.
$controllerName = ucfirst($urlParts[0]) . 'Controller';

// 5. Figure out what action they want the Manager to do.
// Example: URL is '/brief/create' -> The method is 'create' ( should be a pretty easy concept yus).
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

// Find the exact location of the Manager in our folders
$controllerClass = "App\\Controllers\\" . $controllerName;

// 6. If the Manager exists, wake them up and tell them to do the action(nkounou 9a9ssassin ta3 7lewa ama hey, it works 🥱).
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        echo "Hey team, the Router found the Controller, but the method '$methodName' is missing!";
    }
} else {
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>Team note: The Receptionist couldn't find '$controllerName'. Did you create it in app/Controllers?</p>";
}
