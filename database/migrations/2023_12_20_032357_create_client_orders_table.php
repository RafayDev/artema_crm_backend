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
        Schema::create('client_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->Integer('client_invoice_id');
            $table->string('status');
            $table->string('tracking_no')->nullable();
            $table->string('courier')->nullable();
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
        Schema::dropIfExists('client_orders');
    }
};
