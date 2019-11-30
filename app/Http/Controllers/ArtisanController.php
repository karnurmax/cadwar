<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class ArtisanController extends Controller
{
    public function MigrateRefresh(){
        $exitCode = Artisan::call('migrate:refresh', [
            '--force' => true,
        ]);
        return $exitCode;
    }
}
