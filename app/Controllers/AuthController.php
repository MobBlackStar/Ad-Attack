<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agency;
use App\Core\Session;
use App\Core\Auth;

// TEAM: Donyes (Gatekeeper). The Security Manager.
// I've updated this to fix the "Room Mismatch" error.
class AuthController extends Controller {

    public function register() {
        Auth::requireGuest(); 
        $this->view('auth/register',['title' => 'Ad-Attack | Inscription']);
    }

    public function store() {
        Auth::requireGuest(); 
 
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // --- THE BOUNCER (Security Logic) ---
        if (strlen($password) < 8) {
            Session::flash('error', 'Le mot de passe est trop court !');
            header('Location: ' . BASE_URL . '/auth/register');
            exit();
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
            Session::flash('error', 'Le mot de passe doit être complexe (Majuscule, Chiffre, Symbole).');
            header('Location: ' . BASE_URL . '/auth/register');
            exit();
        }

        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake.");
        }

        $agencyModel = new Agency();

        // Check if email is already taken
        if ($agencyModel->findByEmail($email)) {
            Session::flash('error', 'Cet email est déjà utilisé !');
            header('Location: ' . BASE_URL . '/auth/register');
            exit();
        }

        if ($agencyModel->register($name, $email, $password)) {
            Session::flash('message', 'Votre agence est inscrite !');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    public function login() {
        Auth::requireGuest(); 
        $this->view('auth/login', ['title' => 'Ad-Attack | Connexion']);
    }

    public function authenticate() {
        Auth::requireGuest(); 
        
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake.");
        }

        $email = $_POST['email'];
        $password = $_POST['password']; 

        $agencyModel = new Agency();
        $user = $agencyModel->findByEmail($email); 

        if ($user && password_verify($password, $user->password)) {
            Session::set('user_id', $user->id);
            Session::set('user_name', $user->name);
            Session::flash('message', 'Heureux de vous revoir !');
            header('Location: ' . BASE_URL . '/home');
            exit();
        } else {
            Session::flash('message', 'Identifiants incorrects.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
    
    // --- PROFILE ROOMS ---

    public function profile() {
        Auth::requireLogin();
        $agencyModel = new Agency();
        $user = $agencyModel->find(Auth::id());

        $this->view('auth/profile', [
            'title' => 'Mon Agence',
            'user' => $user
        ]);
    }

    // RITEJ: Renamed from 'updateProfile' to 'update' to match the URL
    // TEAM: This handles the "Rename Agency" form.
    public function update() {
        Auth::requireLogin();

        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) {
            die("Security Error: Invalid Handshake.");
        }

        $newName = trim($_POST['name']);
        
        if (!empty($newName)) {
            $agencyModel = new Agency();
            $agencyModel->updateName(Auth::id(), $newName);
            
            // Update the ID Badge instantly
            Session::set('user_name', $newName);
            Session::flash('message', 'Identity updated! ✨');
        }

        header('Location: ' . BASE_URL . '/auth/profile');
        exit();
    }

    public function deleteAccount() {
        Auth::requireLogin();
        $agencyModel = new Agency();
        $agencyModel->delete(Auth::id()); 
        Session::destroy();
        session_start();
        Session::flash('message', 'Compte supprimé.');
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
}