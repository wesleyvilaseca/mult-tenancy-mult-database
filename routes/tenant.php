<?php

use App\Http\Controllers\Tenant\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('tenant/store', [CompanyController::class, 'store'])->name('tenant.store');

Route::get('/', function () {
    return 'tenant';
});
