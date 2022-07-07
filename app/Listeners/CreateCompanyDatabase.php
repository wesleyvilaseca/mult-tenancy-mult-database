<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use App\Events\DatabaseCreated;
use App\Tenant\Database\DatabaseManager;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDatabase
{

    private $databaseManager;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        //
        $this->databaseManager = $databaseManager;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->get_company();
        $created = $this->databaseManager->create_database($company);
        if (!$created) {
            throw new Exception('Erro on create database');
        }

        //run migrations
        event(new DatabaseCreated($company));
    }
}
