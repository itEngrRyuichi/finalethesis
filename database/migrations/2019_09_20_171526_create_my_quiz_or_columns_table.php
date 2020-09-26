<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyQuizOrColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_quiz_or_columns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('myQUiz_or_id');
            $table->string('myColumn');
            $table->timestamps();

            //Foreign Key
            $table->foreign('myQUiz_or_id')
                ->references('id')->on('my_quiz_ors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_quiz_or_columns');
    }
}
