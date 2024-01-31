<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarydetails', function (Blueprint $table) {
            $table->id();
            $table->integer('salaryid');
            $table->integer('roz_id')->nullable();
            $table->integer('type');
            $table->integer('amount');
            $table->string('note');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salarydetails');
    }
}
