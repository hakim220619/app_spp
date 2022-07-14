<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            switch (Auth::user()->role_id) {
                case 1:
                    $type = "/admin";
                    break;
                case 2:
                    $type = "/operator/pembayaran";
                    break;
                case 3:
                    $type = "/siswa";
            }
            return redirect($type);
        }

        return $next($request);
    }
}
