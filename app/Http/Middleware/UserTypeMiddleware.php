<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , string $userType): Response
    {
        if ($request->user()->user_type === $userType) {
            return $next($request);
        }

        if ($request->user()->user_type === 'admin') {
            return to_route('dashboard.index');
        }

        if ($request->user()->user_type === 'qc') {
            return to_route('qc.calls.index');
        }

        return to_route('dashboard');
    }
}
