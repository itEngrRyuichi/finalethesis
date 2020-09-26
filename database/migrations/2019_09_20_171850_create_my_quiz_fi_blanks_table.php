<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyQuizFiBlanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_quiz_fi_blanks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('myQuiz_fi_id');
            $table->string('myAnswer');
            $table->timestamps();

            //Foreign Key
            $table->foreign('myQuiz_fi_id')
                ->references('id')->on('my_quiz_fis')
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
        Schema::dropIfExists('my_quiz_fi_blanks');
    }
}
