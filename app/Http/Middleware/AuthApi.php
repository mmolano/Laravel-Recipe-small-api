<?php

namespace App\Http\Middleware;

use App\Facades\ErrorHandler;
use App\Models\Authenticate;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class AuthApi
{
    private function checkRoute(Authenticate $auth): bool
    {
        $getAllowedRoutes = json_decode($auth->routes);
        $getRequestedRoute = explode(':', Route::getCurrentRoute()->getName());

        if (empty($getAllowedRoutes) || empty($getRequestedRoute)) {
            return false;
        } elseif (in_array('*', $getAllowedRoutes) || in_array($getRequestedRoute[0], $getAllowedRoutes)) {
            return true;
        }

        return false;
    }

    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!$request->bearerToken()) {
            ErrorHandler::write(1, true);
        } elseif (!$consumer = Authenticate::where('token', $request->bearerToken())
            ->first()) {
            ErrorHandler::write(2, true);
        } elseif (!$this->checkRoute($consumer)) {
            ErrorHandler::write(3, true);
        }
        return $next($request);
    }
}
