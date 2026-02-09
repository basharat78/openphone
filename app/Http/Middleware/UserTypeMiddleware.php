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
        $currentUserType = $request->user()->user_type;

        // Admins can access everything, OR match the required type
        if ($currentUserType === 'admin' || $currentUserType === $userType) {
            return $next($request);
        }

        // Otherwise redirect to their respective dashboard
        if ($currentUserType === 'qc') {
            return to_route('qc.dashboard');
        }

        return to_route('dashboard');
    }
}
