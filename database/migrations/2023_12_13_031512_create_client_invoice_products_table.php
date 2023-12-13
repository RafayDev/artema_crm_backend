<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_invoice_products', function (Blueprint $table) {
            $table->id();
            $table->Integer('client_invoice_id');
            $table->Integer('product_id');
            $table->Integer('quantity');
            $table->Integer('price');
            $table->Integer('total');
            $table->string('sku');
            $table->string('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_invoice_products');
    }
};
