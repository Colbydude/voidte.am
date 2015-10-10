<?php

use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function ($table) {
            $table->increments('id');
            $table->string('url');
            $table->string('hash');
            $table->string('user');
            $table->string('via');
            $table->integer('uses');
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
        Schema::drop('links');
    }
}
