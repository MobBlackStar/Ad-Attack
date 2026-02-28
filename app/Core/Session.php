<?php
namespace App\Core;

// TEAM: The internet has amnesia. Every time a user clicks a link, the server forgets who they are, donc bch narte7ou mel 7arb hedhi, n7otou badge invisible.
// This is our "ID Badge System". It uses PHP Sessions to remember people as they navigate the site.
class Session {
    
    // Gatekeeper: Use this when a user successfully logs in. 
    // Think of this as writing their name on a physical badge and pinning it to their shirt.
    // Example: Session::set('user_id', $user->id);
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    // @Everyone: Use this to read what is written on the badge.
    // Example: $id = Session::get('user_id');
    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    // Check if the badge has a specific piece of information.
    public static function exists($key) {
        return isset($_SESSION[$key]);
    }

    // Gatekeeper: Use this for the Logout function. 
    // function hedhi t9atta3 w tharress l badge, iwalli lmouwaten stranger again.
    public static function destroy() {
        session_unset();
        session_destroy();
    }

    
    // ARCHITECT HELPERS (hedhol chwayya shortcuts lel team)
    

    // Client & Creative: Use this to protect your pages
    // If they don't have a badge, you can kick them out.
    // Example: if (!Session::isLoggedIn()) { /* Redirect to login */ }
    public static function isLoggedIn() {
        return self::exists('user_id');
    }

    // TEAM: hedha kima l far taa l karhba, 7aja ta3mi ( bon not that flashy bien sure). It's a sticky note we put on the user's screen.
    // It shows up ONCE (like "Wrong Password!" or "Challenge Created!") and then instantly deletes itself.
    // This will def be a 'cooking' move, use it.
    public static function flash($key, $message = '') {
        // If we give it a message, write the sticky note.
        if (!empty($message)) {
            self::set($key, $message);
        } 
        // If we don't give it a message, read the sticky note, then throw it in the trash.
        else if (self::exists($key)) {
            $sessionMessage = self::get($key);
            unset($_SESSION[$key]); 
            return $sessionMessage;
        }
        return '';
    }
    //w9ayet bonus
    // SECURITY: CSRF (Cross-Site Request Forgery) SHIELD


    // TEAM: This generates the "Secret Handshake Word".
    // Gatekeeper: Put this inside a hidden input in your Login/Register forms.
    public static function generateCSRF() {
        // If we don't have a secret word yet, create a random one
        if (!self::exists('csrf_token')) {
            self::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return self::get('csrf_token');
    }

    // TEAM: This checks if the user knows the Secret Handshake.
    // Gatekeeper: Check this in your AuthController before saving the user.
    public static function checkCSRF($token) {
        if (self::exists('csrf_token') && self::get('csrf_token') === $token) {
            return true; // They know the handshake. Let them in.
        }
        return false; // Hacker detected!
    }
}