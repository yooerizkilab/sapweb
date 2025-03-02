<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSAPSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $companyDB = session('sap_company_db');
        $cacheKey = 'sap_session_' . Auth::id() . '_' . $companyDB;

        if (Cache::has($cacheKey)) {
            // Refresh session SAP jika ada aktivitas
            Cache::put($cacheKey, Cache::get($cacheKey), now()->addMinutes(25));
        } else {
            // Jika session expired, logout user
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->withErrors(['message' => 'Session expired, please login again.']);
        }

        return $next($request);
    }
}
