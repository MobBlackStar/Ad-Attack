<?php
namespace App\Core;

// TEAM: This is our "Security Guard". 
class Auth {

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

    // A quick way to get the current user's ID from their ID Badge
    public static function id() {
        return Session::get('user_id');
    }

}