<?php
namespace App\Helpers;

class Mailer
{
    public static function Send(string $to, string $subject, string $message, $headers = null)
    {
        try {
            if (!isset($headers)) {
                $headers = [];
            }
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=UTF-8';
            return mail($to, $subject, $message, implode("\r\n", $headers));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
