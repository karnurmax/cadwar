<?php
namespace App\Helpers;

class Mailer
{
    public static function Send(string $to, string $subject, string $message, $headers = null)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
}
