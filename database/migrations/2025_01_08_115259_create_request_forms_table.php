<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('requestformstatus_id');
            $table->string('emailAddress');
            $table->date('date')->nullable();
            $table->string('nameOfRequester')->nullable();
            $table->string('nameOfLearner')->nullable();
            $table->string('schoolYearGraduated')->nullable();
            $table->string('issuedBy')->nullable();
            $table->string('purpose')->nullable();
            $table->string('documentCategory')->nullable();
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
        Schema::dropIfExists('request_forms');
    }
}
