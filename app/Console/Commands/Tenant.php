<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Tenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    private $managerTenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $managerTenant)
    {
        parent::__construct();

        $this->managerTenant = $managerTenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        if ($id = $this->argument('id')) {
            $company = Company::find($id);
            if ($company) return $this->exec_command($company, $command);
        }

        $companies = Company::all();
        foreach ($companies as $company) {
            $this->exec_command($company, $command);
        }
    }

    public function exec_command(Company $company, $command)
    {
        $this->managerTenant->setConnection($company);

        $this->info("Connecting Company {$company->name}");

        Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/tenant'
        ]);

        $this->info("End Connecting Company {$company->name}");
        $this->info("---------------------------------------");
    }
}
