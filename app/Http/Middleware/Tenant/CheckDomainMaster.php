<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;

class CheckDomainMaster
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
        if ($request->getHost() !== config('tenant.domain_master')) return abort('401');

        return $next($request);
    }
}
