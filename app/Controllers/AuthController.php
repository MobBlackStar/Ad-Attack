<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agency;
use App\Core\Session;
use App\Core\Auth; // <-- Fedi's new Walkie-Talkie!

// L'ÉQUIPE : Je suis la Manager de la Sécurité (Ritej).
class AuthController extends Controller {

    // ==========================================
    // PARTIE INSCRIPTION (REGISTER)
    // ==========================================

    public function register() {
        // FEDI'S TOOL : Si la personne a DÉJÀ un badge, on lui interdit de s'inscrire à nouveau !
        Auth::requireGuest(); 

        $this->view('auth/register',['title' => 'Inscription Agence']);
    }

    public function store() {
        Auth::requireGuest(); 

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $agencyModel = new Agency();
        $success = $agencyModel->register($name, $email, $password);

        if ($success) {
            Session::flash('success', 'Votre agence est inscrite ! Connectez-vous.');
            // Fedi a ajouté BASE_URL, on l'utilise pour ne plus avoir de bugs de liens !
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        } else {
            echo "Erreur lors de l'enregistrement.";
        }
    }

    // ==========================================
    // PARTIE CONNEXION (LOGIN)
    // ==========================================

    // RITEJ : Cette fonction affiche le formulaire de connexion
    public function login() {
        Auth::requireGuest(); // On n'affiche pas ça à quelqu'un de déjà connecté

        $this->view('auth/login', ['title' => 'Connexion à l\'Arène']);
    }

    // RITEJ : Cette fonction vérifie la carte d'identité
    public function authenticate() {
        Auth::requireGuest(); 

        $email = $_POST['email'];
        $password = $_POST['password']; // Le mot de passe tapé (ex: 12345)

        $agencyModel = new Agency();
        $user = $agencyModel->findByEmail($email); // On cherche le dossier de l'utilisateur

        // LA LOI DU PROJET : On utilise password_verify pour comparer le mot de passe tapé 
        // avec le mot de passe haché (le puzzle) caché dans la base de données.
        if ($user && password_verify($password, $user->password)) {
            
            // C'est le bon mot de passe ! On lui imprime son Badge d'accès (Session).
            Session::set('user_id', $user->id);
            Session::set('user_name', $user->name);
            
            Session::flash('success', 'Heureux de vous revoir, ' . $user->name . ' !');
            header('Location: ' . BASE_URL . '/home');
            exit();
            
        } else {
            // Mauvais mot de passe ou email
            Session::flash('error', 'Identifiants incorrects. Accès refusé.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    // ==========================================
    // PARTIE DÉCONNEXION (LOGOUT)
    // ==========================================

    // RITEJ : Cette fonction déchire le badge de l'utilisateur et le jette dehors
    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
}