<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanSupplierKantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_supplier_kantas', function (Blueprint $table) {
            $table->id();
            $table->integer('supplierid');
            $table->integer('type');
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
        Schema::dropIfExists('toman_supplier_kantas');
    }
}
