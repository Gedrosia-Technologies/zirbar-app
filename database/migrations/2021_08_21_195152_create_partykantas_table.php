<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartykantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partykantas', function (Blueprint $table) {
            $table->id();
            $table->integer('partyid');
            $table->integer('type');
            $table->integer('rozid')->default(0);
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
        Schema::dropIfExists('partykantas');
    }
}
