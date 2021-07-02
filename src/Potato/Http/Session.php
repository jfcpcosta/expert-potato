<?php namespace Potato\Http;

class Session {

    public static function start(): void {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function get(string $key, mixed $defaultValue = null): mixed {
        static::start();
        return isset($_SESSION[$key]) ? unserialize($_SESSION[$key]) : $defaultValue;
    }

    public static function set(string $key, mixed $value): void {
        static::start();
        $_SESSION[$key] = serialize($value);
    }

    public static function remove(string $key): void {
        static::start();
        unset($_SESSION[$key]);
    }

    public static function id(string $id = null): string {
        static::start();

        if (is_null($id)) {
            return session_id();
        }

        session_id($id);
        return $id;
    }

    public static function destroy(): void {
        static::start();

        session_unset();
        session_destroy();
    }
}