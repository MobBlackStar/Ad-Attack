<?php
// TEAM: Welcome to the Router hehehe, Think of this file as the "Receptionist" of our building Yusss.
// Nobody creates physical pages like 'login.php' anymore. 
// Every user comes here first, and this script directs them to the right Controller.

// 1. Give everyone the Phonebook (Composer Autoload) so classes find each other.
require_once '../vendor/autoload.php';

// 2. Start the Session (We need this later to remember who is logged in)
session_start();

// ---------------------------------------------------------
// Madem famma issues bin viortual w local we use this: DYNAMIC BASE URL
// This prevents the team from fighting over CSS paths.
// It automatically detects if someone is using a VirtualHost or Localhost.
// ---------------------------------------------------------
$base = 'http://' . $_SERVER['HTTP_HOST'];
$folder = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $base . $folder);
// ---------------------------------------------------------

// 3. Look at what the user typed in the URL. If they typed nothing, send them to 'home'.
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

// 4. Figure out which "Manager" (Controller) they want to talk to.
// Example: URL is '/login' -> We look for 'LoginController'.
$controllerName = ucfirst($urlParts[0]) . 'Controller';

// 5. Figure out what action they want the Manager to do.
// Example: URL is '/brief/create' -> The method is 'create' (should be a pretty easy concept yus).
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

// Find the exact location of the Manager in our folders
$controllerClass = "App\\Controllers\\" . $controllerName;

// 6. If the Manager exists, wake them up and tell them to do the action (nkounou 9a9ssassin ta3 7lewa ama hey, it works 🥱).
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $methodName)) {
        // THE FIX: We need to pass the parameters (like the ID) to the function!
        // We remove the controller name and method name from the list...
        unset($urlParts[0]); 
        unset($urlParts[1]); 
        
        // ...and send the rest (the ID) to the Manager.
        call_user_func_array([$controller, $methodName], $urlParts);
    } else {
        echo "Hey team, the Router found the Controller, but the method '$methodName' is missing!";
    }
} else {
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>Team note: The Receptionist couldn't find '$controllerName'. Did you create it in app/Controllers?</p>";
}