<?php
namespace App\Helpers;

class Mailer
{
    public static function Send(string $to, string $subject, string $message)
    {
        return mail($to, $subject, $message);
    }
}
