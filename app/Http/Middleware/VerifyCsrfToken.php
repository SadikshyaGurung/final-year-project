<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{// App/Http/Middleware/VerifyCsrfToken.php
protected $except = [
    'api/*',          // all API routes are excluded
    '/login',
    '/register',
    '/logout',
    '/forgot-password',
    '/reset-password',
];

}
