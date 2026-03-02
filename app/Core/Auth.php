<?php
namespace App\Core;

// TEAM: This is our "Security Guard". 
// Donyes (Gatekeeper): Use this to protect the 'Profile' or 'Logout' pages.
// Moataz & Sarra: Use this to lock your "Create" and "Submit" rooms.
class Auth {

    // Kicks out anyone who isn't logged in.
    public static function requireLogin() {
        if (!Session::isLoggedIn()) {
            Session::flash('message', 'Access Denied: Please sign in to participate.');
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    // Prevents logged-in users from seeing the Login page again.
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