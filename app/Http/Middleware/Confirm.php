<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Confirm
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
        $user = Auth::user();
        if (!$user->confirmed) {
            $request->session()->flash('error', 'Your account has not been activated yet.');
            Auth::logout();
            return redirect('/auth/login');
        }
        return $next($request);
    }
}
