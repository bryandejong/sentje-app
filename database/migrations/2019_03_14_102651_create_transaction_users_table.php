<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_users', function (Blueprint $table) {
            $table->integer('users_id')->unsigned();
            $table->integer('transaction_requests_id')->unsigned();
            $table->dateTime('paid');
            $table->timestamps();

            $table->foreign('users_id')
            ->references('id')
            ->on('users');

            $table->foreign('transaction_requests_id')
            ->references('id')
            ->on('transaction_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_users');
    }
}
