<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyToRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_requests', function($table)
        {
            $table->string('currency');

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
        Schema::table('transaction_requests', function($table)
        {
            $table->dropForeign('currency');
            $table->dropColumn('currency');
        });
    }
}
