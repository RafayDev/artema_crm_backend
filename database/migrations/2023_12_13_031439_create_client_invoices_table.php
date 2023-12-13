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
        Schema::create('client_invoices', function (Blueprint $table) {
            $table->id();
            $table->Integer('client_query_id');
            $table->Integer('user_id');
            $table->Integer('company_id');
            $table->string('frieght_charges')->nullable();
            $table->string('sales_tax')->nullable();
            $table->string('sub_total');
            $table->string('total');
            $table->string('payment_link')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('client_invoices');
    }
};
