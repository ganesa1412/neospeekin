<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('tipe') == "admin" || Session::get('tipe') == "ceo") {
            return $next($request);
        }else{
            return redirect('login');
        }
    }
}
