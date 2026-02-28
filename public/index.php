<?php
// TEAM : Le "Réceptionniste" (Router) du projet. 
// Il lit l'URL et appelle le bon Manager (Contrôleur).

// 1. On charge le carnet d'adresses (Autoload)
require_once '../vendor/autoload.php';

// 2. On démarre la mémoire (Session)
session_start();

// 3. On découpe l'URL pour savoir où l'utilisateur veut aller
// On cherche la variable "url" (configurée dans notre .htaccess)
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

// 4. On prépare le nom du Manager (Controller)
// Exemple : url = 'ad/show' -> $controllerName = 'AdController'
$controllerName = ucfirst($urlParts[0]) . 'Controller';

// 5. On prépare le nom de l'action (Method)
// Exemple : url = 'ad/show' -> $methodName = 'show'
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

// Le chemin complet vers la classe (avec le namespace de Fedi)
$controllerClass = "App\\Controllers\\" . $controllerName;

// 6. EXECUTION : On vérifie si tout existe avant de lancer le code
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $methodName)) {
        
        // TEAM : Ici on récupère les "petites notes" (les paramètres comme l'ID)
        // On enlève le nom du contrôleur et de la méthode pour ne garder que les IDs
        unset($urlParts[0]);
        unset($urlParts[1]);
        $params = $urlParts ? array_values($urlParts) : [];

        // ON APPELLE LE MANAGER !
        // (On lui donne les paramètres s'il y en a)
        call_user_func_array([$controller, $methodName], $params);
        
    } else {
        echo "<h1>404 - Méthode introuvable</h1>";
        echo "<p>Team : La fonction '$methodName' n'existe pas dans le fichier $controllerName.php</p>";
    }
} else {
    echo "<h1>404 - Manager introuvable</h1>";
    echo "<p>Team : Avez-vous créé le fichier $controllerName.php dans app/Controllers ?</p>";
}