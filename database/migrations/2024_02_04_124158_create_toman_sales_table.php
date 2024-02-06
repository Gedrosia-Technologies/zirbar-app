<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('clientid');
            $table->integer('type');
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
        Schema::dropIfExists('toman_sales');
    }
}
