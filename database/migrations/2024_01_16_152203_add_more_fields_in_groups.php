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
        Schema::table('groups', function (Blueprint $table) {
            $table->string("state")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("account_no")->nullable();
            $table->string("iban")->nullable();
            $table->string("contact_person")->nullable();
            $table->string("assigned_to")->nullable();
            $table->string("notes")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
        $table->dropColumn("state");
        $table->dropColumn("bank_name");
        $table->dropColumn("account_no");
        $table->dropColumn("iban");
        $table->dropColumn("contact_person");
        $table->dropColumn("assigned_to");
        $table->dropColumn("notes");
        });
    }
};
