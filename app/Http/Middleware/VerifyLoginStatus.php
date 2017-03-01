<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyLoginStatus {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check() && Auth::user()->status == 0) {
            Auth::logout();
            if ($request->wantsJson()) {
                return response()->json(['error' => "Your account is not activated yet! Please check activation email in your inbox and activate your account."], 401);
            }
            return redirect()->to('/')->with('error-message', 'Your account is not activated yet! Please check activation email in your inbox and activate your account.');
        } 
        return $next($request);
    }

}
