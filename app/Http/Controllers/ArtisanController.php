<?php

namespace App\Http\Controllers;

use Artisan;

class ArtisanController extends Controller
{
    public function MigrateRefresh()
    {
        $runArtisanKey = env('RUN_ARTISAN_KEY');
        if (false === isset($runArtisanKey)) {
            return '"RUN_ARTISAN_KEY" not_found; Make sure that .env file has this key=>value pair';
        }
        if (false === isset($_GET['key'])) {
            return 'send "key" params in query string (?key=123)';
        }
        $keyFromQueryString = $_GET['key'];

        if ($keyFromQueryString !== $runArtisanKey) {
            return 'wrong key';
        }
        $exitCode = Artisan::call('migrate:refresh', [
            '--force' => true,
        ]);
        return $exitCode;
    }
}
