<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->Integer('unitid');
            $table->decimal('pcounter', 12, 2);
            $table->decimal('counter', 12, 2);
            $table->decimal('rate', 12, 2);
            $table->decimal('liters', 12, 2);
            $table->date('date');
            $table->boolean('isclosed')->default(0);
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
        Schema::dropIfExists('sells');
    }
}
