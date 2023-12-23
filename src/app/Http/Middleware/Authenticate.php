<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // routeIs()は、指定したルート名に一致するかどうかを判定する
        if ($request->routeIs('admin.*')) { 
            // expectsJson()は、リクエストがJSONであるかどうかを判定する
            return $request->expectsJson() ? null : route('admin.login');
        }

        return $request->expectsJson() ? null : route('login');
    }
}
