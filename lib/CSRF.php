<?php
namespace App\Lib;

class CSRF {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    public static function token() {
        return $_SESSION['csrf_token'] ?? self::start();
    }
    public static function check($token) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return hash_equals($_SESSION['csrf_token'] ?? '', (string)$token);
    }
}
