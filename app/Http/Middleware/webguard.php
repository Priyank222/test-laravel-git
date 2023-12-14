<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Customer_model;
use Illuminate\Support\Facades\Redirect;

class webguard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = [];
        if (session()->has('customer_id')) {
            $user = Customer_model::find(session()->get('customer_id'));
        } else {
            Redirect::to('login')->send();
            // return redirect('login');
        }
        $request->attributes->add(['user' => $user]);
        return $next($request);
    }
}
