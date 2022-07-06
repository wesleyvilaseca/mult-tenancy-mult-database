<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;

use function Psy\debug;

class TenantMiddleware
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

        $manager =  app(ManagerTenant::class);

        if ($manager->domain_is_master()) {
            return $next($request);
        }

        $company = $this->get_company($request->getHost());

        if (!$company && $request->url() != route('404')) {
            return redirect()->route('404');
        } else if ($request->url() != route('404') && !$manager->domain_is_master()) {
            $manager->setConnection($company);
        }

        return $next($request);
    }

    public function get_company($host)
    {
        return Company::where(['domain' => $host, 'active' => 'S'])->first();
    }
}
