<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('passport_number', 50);
            $table->string('last_name', 150);
            $table->string('first_name', 150);
            $table->string('middle_name', 150)->nullable();
            $table->string('position', 150)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('address', 250)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
