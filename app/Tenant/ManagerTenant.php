<?php

namespace App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{
    public function setConnection(Company $company)
    {
        DB::purge('tenant_mysql');

        config()->set('database.connections.tenant_mysql.host', $company->db_hostname);
        config()->set('database.connections.tenant_mysql.port', $company->port);
        config()->set('database.connections.tenant_mysql.database', $company->db_database);
        config()->set('database.connections.tenant_mysql.username', $company->db_username);
        config()->set('database.connections.tenant_mysql.password', $company->db_password);

        DB::reconnect('tenant_mysql');

        Schema::connection('tenant_mysql')->getConnection()->reconnect();
    }

    public function domain_is_master()
    {
        return request()->getHost() == config('tenant.domain_master');
    }
}
