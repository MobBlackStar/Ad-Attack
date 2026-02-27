<?php
namespace App\Core;

// TEAM: Every Controller you make MUST extend this class ( mouhemm barcha, khater hedha yarbet bin kol view wel DB(Model)).
// This gives you free tools so you don't have to write boring HTML inclusion code.
abstract class Controller {
    
    // Gatekeeper & Creative: Use this function to show your HTML forms
    // Example: $this->view('login',['title' => 'Sign In']);
    public function view($view, $data =[]) {
        
        // This takes our data array and unpacks it into real variables for the HTML.
        extract($data);

        // Tell PHP exactly where the HTML file lives.
        $viewPath = "../app/Views/" . $view . ".php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Team error: I tried to load the View '$view', but the file is missing in app/Views!");
        }
    }
}