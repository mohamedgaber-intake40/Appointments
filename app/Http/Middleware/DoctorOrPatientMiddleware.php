<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;

class DoctorOrPatientMiddleware
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
        if($request->user()->type == UserType::PATIENT || $request->user()->type == UserType::DOCTOR)
            return $next($request);
        else if($request->user()->type == UserType::ADMIN)
            return redirect()->route('dashboard.index');

    }
}
