<?php

class Config
{
    public static function options()
    {
        static $options = null;

        if ($options === null) {
            $options = require __DIR__ . '/../../app/config/options.php';
        }

        return $options;
    }
    public static function inspection()
    {
        static $options = null;

        if ($options === null) {
            $options = require __DIR__ . '/../../app/config/inspection.php';
        }

        return $options;
    }
    public static function country()
    {
        static $options = null;

        if ($options === null) {
            $options = require __DIR__ . '/../../app/config/country.php';
        }

        return $options;
    }
     public static function get(string $file): array
    {
        $path = __DIR__ . '/../../app/config/' . $file . '.json';
        if (!file_exists($path)) return [];

        $data = json_decode(file_get_contents($path), true);
        return is_array($data) ? $data : [];
    }
}
