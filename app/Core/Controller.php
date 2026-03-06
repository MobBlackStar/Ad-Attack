<?php
namespace App\Core;

abstract class Controller {

    // Dès qu'un Manager (ex: AuthController) s'allume, il vérifie d'abord si l'utilisateur n'est pas endormi !
    public function __construct() {
        // J'appelle mon Gardien du Temps sur chaque page.
        Auth::checkInactivity();
    }

    // Gatekeeper & Creative: Use this function to show your HTML forms
    public function view($view, $data =[]) {
        extract($data);
        $viewPath = "../app/Views/" . $view . ".php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Team error: I tried to load the View '$view', but the file is missing in app/Views!");
        }
    }
}