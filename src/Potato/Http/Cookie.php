<?php namespace Potato\Http;

class Cookie {
    
    public static function get(string $key, mixed $defaultValue = null): ?string {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $defaultValue;
    }

    public static function set(string $key, string $value, int $time = 3600): void {
        setcookie($key, $value, time() + $time);
    }
}