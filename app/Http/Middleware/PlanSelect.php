<?php
namespace App\Http\Middleware;

use Closure;
use Session;
class PlanSelect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(isset($request->plan_id)){
            $request->session()->put('Plan', $request->plan_id);
        }

        return $next($request);
    }
}
