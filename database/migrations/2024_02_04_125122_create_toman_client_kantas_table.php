<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanClientKantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_client_kantas', function (Blueprint $table) {
            $table->id();
            $table->integer('clientid');
            $table->integer('type'); // 1 credit 2 is debit
            $table->decimal('amount', 20, 2);
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
        Schema::dropIfExists('toman_client_kantas');
    }
}
