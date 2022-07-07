<?php

namespace App\Http\Controllers\Tenant;

use App\Events\CompanyCreated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {
        $rand = str_replace('-', '', Str::slug(Carbon::now())) ;
        $company = $this->company->create(
            [
                'api_key' => '4321',
                'api_uri' => 'teste.com.br/api',
                'name' => 'teste',
                'domain' => $rand . 'teste.com.br',
                'db_database' => 'teste_db_' .  $rand,
                'db_hostname' => request()->ip(),
                'port' => '3308',
                'db_username' => 'root',
                'db_password' => 'root',
                'active'
            ]
        );

        event(new CompanyCreated($company));

        dd($company);
    }
}
