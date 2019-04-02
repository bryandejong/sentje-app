<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_requests', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->integer('bank_account_id')->unsigned();
            $table->float('amount');
            $table->dateTime('created');
            $table->dateTime('sent');
            $table->string('note')->nullable();
            $table->string('image_url');
            $table->timestamps();
            
            $table->foreign('bank_account_id')
            ->references('id')
            ->on('bank_accounts');
            
            $table->foreign('sender_id')
                ->references('id')
                ->on('users');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_requests');
    }
}
