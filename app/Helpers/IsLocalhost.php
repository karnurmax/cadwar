<?php
namespace App\Helpers;

class IsLocalhost
{
    public static function Check()
    {
        return (strpos($_SERVER['HTTP_ORIGIN'], 'localhost') !== false);
    }
}
