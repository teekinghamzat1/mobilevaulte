<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('adminloginform');
        }

        $admin = Auth::guard('admin')->user();

        if ($admin->type !== 'Super Admin') {
            abort(403, 'Unauthorized. Super Admin access required.');
        }

        return $next($request);
    }
}
