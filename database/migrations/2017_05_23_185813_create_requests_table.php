<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('statusRequests', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');

        });

        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('days')->unsigned();
            $table->date('date_begin');
            $table->date('date_end');
            $table->string('observation');
            $table->integer('user_id')->unsigned();
            $table->integer('statusRequests_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('statusRequests_id')->references('id')->on('statusRequests')->onDelete('cascade');

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
        Schema::dropIfExists('requests');
    }
}
