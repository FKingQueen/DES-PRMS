<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->string('password');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('position')->nullable();
            $table->string('itemNumber')->nullable();
            $table->string('employeeNumber')->unique();
            $table->date('datePermanency')->nullable();
            $table->date('dateOrigAppointment')->nullable();
            $table->date('dateLastProAppointment')->nullable();

            $table->string('homeAddress')->nullable();
            $table->string('contactNumber', 15)->nullable();
            $table->string('emailAddress');
            $table->date('dateOfBirth')->nullable();
            $table->string('civilStatus')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('majorSpecialization')->nullable();
            $table->string('minor')->nullable();
            $table->string('civilServiceEligibility')->nullable();
            $table->string('highestEducationAttainment')->nullable();
            $table->string('schoolRole')->nullable();

            $table->string('ggisbpno')->nullable();
            $table->string('tin')->nullable();
            $table->string('basicSalary')->nullable();
            $table->string('salaryGradeLevel')->nullable();
            $table->string('stepIncrement')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('contactPerson')->nullable();
            $table->string('teachingLoads')->nullable();


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
        Schema::dropIfExists('users');
    }
}
