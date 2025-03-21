<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspended
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user is suspended (assuming 'status' column exists)
            if ($user->account_status === 'suspended') {
                Auth::logout(); // Logout user
                return redirect()->route('account.suspended');       }
        }

        return $next($request);
    }
}
