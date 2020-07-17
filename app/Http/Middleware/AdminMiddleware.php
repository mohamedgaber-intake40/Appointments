<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;

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
        if($request->user()->type == UserType::ADMIN)
            return $next($request);
        else
            return redirect()->route('home');
    }
}
