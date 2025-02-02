<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->timestamps();
            $table->primary(['user_id', 'contact_id']);

            $table->foreign('user_id')
            ->references('id')
            ->on('users');
            
            $table->foreign('contact_id')
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
        Schema::dropIfExists('user_contacts');
    }
}
