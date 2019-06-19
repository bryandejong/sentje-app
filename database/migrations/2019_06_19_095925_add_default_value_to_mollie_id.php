<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultValueToMollieId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_users', function (Blueprint $table) {
            $table->string('mollie_id')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
    }
}
