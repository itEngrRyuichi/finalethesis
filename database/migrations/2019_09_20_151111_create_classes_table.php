<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('schoolYear_id');
            $table->unsignedBigInteger('semester_id');
            $table->string('name');
            $table->integer('stubcode');
            $table->string('coursecode');
            $table->string('progress');
            $table->binary('classPic_location');
            $table->timestamps();

            //Foreign Keys
            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onDelete('cascade');
            $table->foreign('schoolYear_id')
                ->references('id')->on('school_years')
                ->onDelete('cascade');
            $table->foreign('semester_id')
                ->references('id')->on('semesters')
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
        Schema::dropIfExists('classes');
    }
}
