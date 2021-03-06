migrate_gu<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statusGuards', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');

        });

        Schema::create('guards', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_begin');
            $table->integer('orden');
            $table->integer('days')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('estatus_guardia_id')->unsigned();
            $table->integer('group_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('estatus_guardia_id')->references('id')->on('statusGuards')->onDelete('cascade');

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
        Schema::dropIfExists('guards');
    }
}
