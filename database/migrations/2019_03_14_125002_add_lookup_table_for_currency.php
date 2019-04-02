<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLookupTableForCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('currency')->unique();
        });

        Schema::table('transaction_users', function(Blueprint $table) {
            $table->foreign('currency')
            ->references('currency')
            ->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');

        Schema::table('transaction_users', function(Blueprint $table) {
            $table->dropForeign('currency');
        });
    }
}
