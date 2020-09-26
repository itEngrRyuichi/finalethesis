<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyQuizMuChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_quiz_mu_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('myQuiz_mu_id');
            $table->tinyInteger('myCheck');
            $table->timestamps();

            //Foreign Key
            $table->foreign('myQuiz_mu_id')
                ->references('id')->on('my_quiz_mus')
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
        Schema::dropIfExists('my_quiz_mu_choices');
    }
}
