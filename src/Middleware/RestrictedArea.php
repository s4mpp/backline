<?php

namespace S4mpp\Backline\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;

final class RestrictedArea extends Authenticate
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('backline.login');
    }
}
