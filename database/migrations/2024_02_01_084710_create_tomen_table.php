<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tomen', function (Blueprint $table) {
            $table->id();
            $table->integer('type'); // 1 purchased 2 sell
            $table->integer('partyid');
            $table->integer('acctype'); //debit and credit
            $table->decimal('toman', 20, 2);
            $table->decimal('rate', 20, 2);
            $table->decimal('amount', 20, 2);
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
        Schema::dropIfExists('tomen');
    }
}
