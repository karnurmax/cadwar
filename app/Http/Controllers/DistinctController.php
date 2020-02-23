<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistinctController extends Controller
{
    public function get(Request $request, $tableName, $column)
    {
        return \DB::table($tableName)->select("$column as text", "$column as value")->distinct()->get();
    }
}
