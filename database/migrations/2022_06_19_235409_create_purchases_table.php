<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('liters', 12, 2);
            $table->decimal('liters_sold', 12, 2)->default(0.00);
            $table->decimal('drum_rate', 12, 2);
            $table->decimal('liter_rate', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->integer('party')->default(0);
            $table->integer('paid')->default(1);
            $table->date('date');
            $table->integer('status')->default(0); //0 purchase//1 in use//2 sold
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
        Schema::dropIfExists('purchases');
    }
}
