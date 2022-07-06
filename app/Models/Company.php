<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['api_key', 'api_uri', 'name', 'domain', 'db_database', 'db_hostname', 'port', 'db_username', 'db_password', 'active'];
}
