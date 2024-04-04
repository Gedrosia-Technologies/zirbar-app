<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('transactionid');
            $table->integer('stockerid');
            $table->integer('type'); // 1 purchased 2 sell
            $table->decimal('amount', 20, 2); // toman amount
            $table->string('note')->nullable();
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
        Schema::dropIfExists('toman_transaction_details');
    }
}
