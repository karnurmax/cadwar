<?php

namespace App\Http\Middleware;

use Closure;

class CrudWhiteList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $whiteList = ["bases", "employees", "histories"];
        $tableName = $request->route('tableName');
        $allowed = in_array($tableName, $whiteList);
        if (!$allowed) {
            return response('null', 404);
        }
        return $next($request);
    }
}
