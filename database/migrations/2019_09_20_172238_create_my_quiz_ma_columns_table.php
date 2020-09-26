<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyQuizMaColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_quiz_ma_columns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('myQuiz_ma_id');
            $table->string('questionColumn');
            $table->string('myAnswer');
            $table->timestamps();

            $table->foreign('myQuiz_ma_id')
                ->references('id')->on('my_quiz_mas')
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
        Schema::dropIfExists('my_quiz_ma_columns');
    }
}
