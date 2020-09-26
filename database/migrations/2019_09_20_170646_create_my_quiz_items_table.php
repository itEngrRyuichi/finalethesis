<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyQuizItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_quiz_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('myQuiz_id');
            $table->unsignedBigInteger('myQuizType_id');
            $table->integer('myScore');
            $table->timestamps();

            //Foreign Key
            $table->foreign('myQuiz_id')
                ->references('id')->on('my_quizzes')
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
        Schema::dropIfExists('my_quiz_items');
    }
}
