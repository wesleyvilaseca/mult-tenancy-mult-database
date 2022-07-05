<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_key');
            $table->string('api_uri');
            $table->string('name');
            $table->string('domain')->unique();
            $table->string('db_database')->unique();
            $table->string('db_hostname');
            $table->integer('port');
            $table->string('db_username');
            $table->string('db_password');
            $table->enum('active', array('S', 'N'));	
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
