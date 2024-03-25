<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('partyid'); // supplier id in purchase and client id in sale
            $table->integer('type'); // 1 purchased 2 sell
            $table->integer('acctype'); //1 credit and 2 is debit
            $table->decimal('toman', 20, 2);
            $table->decimal('rate', 20, 2);
            $table->decimal('amount', 20, 2);
            $table->integer('isopen')->default(1); // 1 is open 0 is close
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
