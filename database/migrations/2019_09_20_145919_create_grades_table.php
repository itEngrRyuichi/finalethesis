<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('enrollment_id');
            $table->unsignedBigInteger('quarter_id');
            $table->integer('myQuarterlyGrade');
            $table->timestamps();

            $table->foreign('enrollment_id')
                ->references('id')->on('enrollments')
                ->onDelete('cascade');
            $table->foreign('quarter_id')
                ->references('id')->on('quarters')
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
        Schema::dropIfExists('grades');
    }
}
