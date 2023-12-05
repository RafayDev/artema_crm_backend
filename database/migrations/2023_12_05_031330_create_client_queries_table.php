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
        Schema::create('client_queries', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id');
            $table->Integer('product_id');
            $table->Integer('company_id');
            $table->string('quantity');
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
        Schema::dropIfExists('client_queries');
    }
};
