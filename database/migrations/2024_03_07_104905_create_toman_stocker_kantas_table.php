<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanStockerKantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_stocker_kantas', function (Blueprint $table) {
            $table->id();
            $table->integer('stockerid');
            $table->integer('transactiondetailsid');
            $table->integer('transactionid')->default(-1); // id is yes -1 is no
            $table->integer('type'); // 1 is purchase 2 is sell
            $table->decimal('amount', 20, 2);
            $table->string('note')->default("");
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
        Schema::dropIfExists('toman_stocker_kantas');
    }
}
