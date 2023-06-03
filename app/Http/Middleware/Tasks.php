<?php

namespace App\Http\Middleware;

use Closure;

class Tasks
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
        if (!auth()->user()->can_view_tasks)
            return redirect()->route('dashboard');
        return $next($request);
    }
}
