<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agency;
use App\Core\Session;
use App\Core\Auth;

// TEAM: Donyes (Gatekeeper). The Security Manager.
class AuthController extends Controller {

    public function register() {
        Auth::requireGuest(); 
        $this->view('auth/register',['title' => 'Ad-Attack | Inscription']);
    }

    public function store() {
        Auth::requireGuest(); 

        // SECURITY: Architect's CSRF Shield
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake.");
        }

        $agencyModel = new Agency();
        $success = $agencyModel->register($_POST['name'], $_POST['email'], $_POST['password']);

        if ($success) {
            Session::flash('message', 'Votre agence est inscrite ! Connectez-vous.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        } else {
            die("Erreur lors de l'enregistrement.");
        }
    }

    public function login() {
        Auth::requireGuest(); 
        $this->view('auth/login', ['title' => 'Ad-Attack | Connexion']);
    }

    public function authenticate() {
        Auth::requireGuest(); 
        
        // SECURITY: CSRF Shield
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake.");
        }

        $email = $_POST['email'];
        $password = $_POST['password']; 

        $agencyModel = new Agency();
        $user = $agencyModel->findByEmail($email); 

        // THE LAW: password_verify
        if ($user && password_verify($password, $user->password)) {
            Session::set('user_id', $user->id);
            Session::set('user_name', $user->name);
            
            Session::flash('message', 'Heureux de vous revoir, ' . htmlspecialchars($user->name) . ' !');
            header('Location: ' . BASE_URL . '/home');
            exit();
        } else {
            Session::flash('message', 'Identifiants incorrects. Accès refusé.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
}