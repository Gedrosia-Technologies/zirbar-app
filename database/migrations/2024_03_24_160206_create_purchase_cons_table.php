<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseConsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_cons', function (Blueprint $table) {
            $table->id();
            $table->integer('purchaseid');
            $table->integer('stockdetailid');
            $table->integer('accountdetailid')->nullable();
            $table->integer('roznamchacreditid')->nullable();
            $table->integer('roznamchadebitid')->nullable();
            $table->integer('partykantacreditid')->nullable();
            $table->integer('partykantadebitid')->nullable();
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
        Schema::dropIfExists('purchase_cons');
    }
}
