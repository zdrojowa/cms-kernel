<?php

use Illuminate\Support\Facades\Storage;
use Selene\Support\Facades\ModuleManager;

if (!function_exists('get_modules')) {
    function get_modules()
    {
        return ModuleManager::getModules();
    }
}

if (!function_exists('get_module')) {
    function get_module(string $moduleName)
    {
        return ModuleManager::getModule($moduleName);
    }
}

if (!function_exists('camelCase')) {
    function camelCase($str)
    {
        $i = ["-", "_"];
        $str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $str);
        $str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
        $str = str_replace($i, ' ', $str);
        $str = str_replace(' ', '', ucwords(strtolower($str)));
        $str = strtolower(substr($str, 0, 1)) . substr($str, 1);

        return $str;
    }
}

if (!function_exists('uncamelCase')) {
    function uncamelCase($str)
    {
        $str = preg_replace('/([a-z])([A-Z])/', "\\1_\\2", $str);
        $str = strtolower($str);

        return $str;
    }
}

if (!function_exists('storage_asset')) {
    function storage_asset($str)
    {
        return url(Storage::url($str));
    }
}

if (!function_exists('random_letters')) {
    function random_letters(int $length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
