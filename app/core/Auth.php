<?php

class Auth
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function generateToken(): string
    {
        $_SESSION['token'] = bin2hex(random_bytes(32));
        return $_SESSION['token'];
    }

    public static function checkToken(string $token): bool
    {
        return isset($_SESSION['token']) && hash_equals($_SESSION['token'], $token);
    }

    public static function login(array $user): void
    {
        $_SESSION['user'] = [
            'id'    => $user['Id'],
            'login' => $user['Login'],
            'email' => $user['Email']
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }
}
