<?php
namespace App\Core;

// TEAM: This is our "Security Guard". 
// Architect Note: Use this at the top of your Controller functions to protect pages.
class Auth {

    // TEAM: Use this to kick out anyone who isn't logged in.
    // Donyes: This makes your security logic much cleaner!
    // Example: Auth::requireLogin();
    public static function requireLogin() {
        if (!Session::isLoggedIn()) {
            // If no badge, kick them back to the login page
            Session::flash('message', 'Access Denied: You must login first.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    // TEAM: Use this to prevent logged-in users from seeing the Login/Register pages.
    // Example: Auth::requireGuest();
    public static function requireGuest() {
        if (Session::isLoggedIn()) {
            // If they already have a badge, send them to the home page
            header('Location: ' . BASE_URL . '/home');
            exit();
        }
    }

    // TEAM: A quick way to get the current user's ID
    public static function id() {
        return Session::get('user_id');
    }
}