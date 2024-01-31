<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_details', function (Blueprint $table) {
            $table->id();
            $table->integer('sellid');
            $table->integer('partyid')->default(0); //if type 2 then this should carrry partyid
            $table->integer('sourceid')->default(0); //if type 2 then this should carrry partykanta Record Id
            $table->double('rate', 12, 2);
            $table->double('liters', 12, 2);
            $table->double('amount', 20, 2);
            $table->date('date');
            $table->integer('type'); //type 1 for discount //type 2 party kanta //type 3 automatic with default rate
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
        Schema::dropIfExists('sell_details');
    }
}
