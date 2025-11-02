<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'login',           // ✅ Remove the leading slash
        'register',        // ✅ Remove the leading slash
        'logout',
        'forgot-password',
        'reset-password',
        '*login*',         // ✅ Add wildcard pattern
        '*register*',
    ];
}