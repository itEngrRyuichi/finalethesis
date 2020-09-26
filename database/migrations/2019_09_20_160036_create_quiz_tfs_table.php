<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_tfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('statement');
            $table->string('answer');
            $table->tinyInteger('correctionCheck');
            $table->string('trueAnswer');
            $table->string('falseAnswer');
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
        Schema::dropIfExists('quiz_tfs');
    }
}
