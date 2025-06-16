<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            if ($userRole === $role) {
                return $next($request);
            }

            // Redirect based on user role
            switch ($userRole) {
                case 'client':
                    return redirect()->route('client.dashboard');
                case 'professional':
                    return redirect()->route('professional.dashboard');
                case 'admin':
                    return redirect()->route('admin.dashboard');
                default:
                    return redirect('/');
            }
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
