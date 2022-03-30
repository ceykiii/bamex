<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, $role, $permission = null)
    {
        if(!is_null(auth()->user())){
            if (!auth()->user()->hasRole($role)) {
                return redirect('admin/login');
            }else{
                return $next($request);
            }
        }else{
            return redirect('admin/login');
        }

        return $next($request);

    }
}
