<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminKey = $request->bearerToken();
        
        $exists = \DB::table('admins')->where('admin_key', $adminKey)->exists();

    if (!$exists) {
        return response()->json(['error' => 'Invalid admin key'], 401);
    }

    return $next($request);
    }
}
