<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
//     protected function redirectTo($request)
// {
//     // For API requests, return JSON instead of redirecting
//     if ($request->expectsJson() || $request->is('api/*')) {
//         abort(response()->json(['message' => 'Unauthenticated.'], 401));
//     }

//     // For web routes, use default login redirect
//     return route('login');
// }
protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        abort(response()->json(['message' => 'Unauthenticated.'], 401));
    }
}


}
