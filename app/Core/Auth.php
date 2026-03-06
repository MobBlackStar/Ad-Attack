<?php
namespace App\Core;

class Auth {

    // LE GARDIEN DU TEMPS (Auto-Logout)
    //  C'est une minuterie. Si personne ne bouge pendant 15 minutes, on éteint la lumière.
    public static function checkInactivity() {
        
        //  La "Valve de Sécurité". 
        // Si on est déjà en train de se connecter ou déconnecter, on n'a pas besoin de vérifier l'inactivité.
        // Ça évite que le Gardien nous jette dehors alors qu'on est déjà dehors ! (Boucle infinie).
        $currentPage = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($currentPage, '/auth/login') !== false || strpos($currentPage, '/auth/logout') !== false) {
            return; 
        }

        if (Session::isLoggedIn()) {
            $now = time();
            $timeout = 15 * 60; // 15 minutes (900s)
            
            $lastActivity = Session::get('last_activity');

            // Si le tampon existe sur le badge, on calcule l'écart
            if ($lastActivity) {
                $idleTime = $now - $lastActivity;
                
                if ($idleTime > $timeout) {
                    // BOUM ! Trop long. On expulse.
                    Session::destroy();
                    session_start(); // On rouvre juste pour le message
                    Session::flash('error', 'Session expirée par sécurité (15 min d\'inactivité).');
                    header('Location: ' . BASE_URL . '/auth/login');
                    exit();
                }
            }
            
            // L'utilisateur a bougé ! On remet le chrono à zéro.
            Session::set('last_activity', $now);
        }
    }

    // Empêche les inconnus d'entrer
    public static function requireLogin() {
        if (!Session::isLoggedIn()) {
            Session::flash('message', 'Access Denied: Please sign in to participate.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    // Empêche les connectés de revenir sur Login/Register
    public static function requireGuest() {
        if (Session::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/home');
            exit();
        }
    }

//  Un moyen rapide d'obtenir l'ID de l'utilisateur actuel à partir de son Badge (Session).
    public static function id() {
        return Session::get('user_id');
    }
}