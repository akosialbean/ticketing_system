<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $department = Auth::user()->u_department;
        $filter = 'mytickets';
        $sortBy = 'ticketid';
        $sortOrder = 'desc';
        if(Auth::user()->u_role === 2){
            return redirect()->intended('/' . $department . '/tickets/' . $filter . '/' . $sortBy . '/' . $sortOrder)->with('success', 'Welcome back ' . Auth::user()->u_fname . '!');
        }
        return $next($request);
    }
}
