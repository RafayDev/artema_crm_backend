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
        Schema::table('client_queries', function (Blueprint $table) {
            $table->dropColumn("product_id");
            $table->dropColumn("quantity");
            $table->dropColumn("sku");
            $table->dropColumn("size");
            $table->string("status")->after("user_id")->default("pending");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_queries', function (Blueprint $table) {
            $table->Integer('product_id');
            $table->string('quantity');
            $table->string('sku');
            $table->string('size');
            $table->dropColumn("status");
        });
    }
};
