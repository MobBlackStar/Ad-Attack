<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agency;
use App\Core\Session;
use App\Core\Auth;

// TEAM: Donyes (Gatekeeper). The Security Manager.
//  J'ai nettoyé le cerveau de la sécurité pour éviter les conflits de noms.
class AuthController extends Controller {

    public function register() {
        Auth::requireGuest(); 
        $this->view('auth/register',['title' => 'Ad-Attack | Join Us']);
    }

    public function store() {
        Auth::requireGuest(); 
 
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'] ?? '';

//  VÉRIFICATION DES ACCÈS
        if ($password !== $confirm_password) {
            Session::flash('error', 'Passwords do not match!');
            header('Location: ' . BASE_URL . '/auth/register');
            exit();
        }

        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
            Session::flash('error', 'Weak password! Use 8+ chars, 1 Uppercase, 1 Number and 1 Symbol.');
            header('Location: ' . BASE_URL . '/auth/register');
            exit();
        }

        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("Security Error: Invalid Handshake.");

        $agencyModel = new Agency();

        // THE DETECTIVE: No clones allowed
        if ($agencyModel->findByEmail($email)) {
            Session::flash('error', 'This email is already taken!');
            header('Location: ' . BASE_URL . '/auth/register');
            exit();
        }

        if ($agencyModel->register($name, $email, $password)) {
            Session::flash('success', 'Badge Created! You can now login.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    public function login() {
        Auth::requireGuest(); 
        $this->view('auth/login', ['title' => 'Ad-Attack | Identification']);
    }

    public function authenticate() {
        Auth::requireGuest(); 
        
        //  (Anti-Brute Force)
        if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;

        if ($_SESSION['login_attempts'] >= 3) {
            $time_passed = time() - ($_SESSION['last_attempt_time'] ?? 0);
            if ($time_passed < 30) { 
                $wait = 30 - $time_passed;
                Session::flash('error', "🚨 LOCKOUT! Too many attempts. Wait $wait seconds.");
                header('Location: ' . BASE_URL . '/auth/login');
                exit();
            } else {
                $_SESSION['login_attempts'] = 0; 
            }
        }
        
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("Security Error: Invalid Handshake.");

        $email = trim($_POST['email']);
        $password = $_POST['password']; 

        $agencyModel = new Agency();
        $user = $agencyModel->findByEmail($email); 

        if ($user && password_verify($password, $user->password)) {
            // SUCCÈS : Effacement du casier judiciaire
            $_SESSION['login_attempts'] = 0;

            Session::set('user_id', $user->id);
            Session::set('user_name', $user->name);
            // On appuie sur "START" pour le détecteur d'inactivité
             

        } else {
           // ÉCHEC : Incrémenter le compteur de tentatives
            $_SESSION['login_attempts']++; 
            $_SESSION['last_attempt_time'] = time(); 

            $left = 3 - $_SESSION['login_attempts'];
            $msg = ($left > 0) ? "Invalid Login. $left attempts left." : "🚨 SHIELD ACTIVE: Lock frozen.";

            Session::flash('error', $msg);
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
    
    public function profile() {
        Auth::requireLogin();
        $model = new Agency();
        $this->view('auth/profile',[
            'title' => 'My Agency Identity',
            'user' => $model->find(Auth::id()),
            'cultivation' => $model->getCultivationRank(Auth::id())
        ]);
    }

    public function updateProfile() {
        Auth::requireLogin();
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("Security Error");

        $newName = trim($_POST['name']);
        if (!empty($newName)) {
            $agencyModel = new Agency();
            $agencyModel->updateName(Auth::id(), $newName);
            Session::set('user_name', $newName);
            Session::flash('message', 'Agency designation updated! ✨');
        }
        header('Location: ' . BASE_URL . '/auth/profile');
        exit();
    }

    public function deleteAccount() {
        Auth::requireLogin();
        if (!Session::checkCSRF($_POST['csrf_token'] ?? '')) die("Security Error");

        $agencyModel = new Agency();
        $agencyModel->delete(Auth::id()); 

        Session::destroy();
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
}