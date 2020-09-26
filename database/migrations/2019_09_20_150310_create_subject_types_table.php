<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gradingCriteria_id');
            $table->string('name');
            $table->timestamps();

            //Foreign Key
            $table->foreign('gradingCriteria_id')
                ->references('id')->on('grading_criterias')
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
        Schema::dropIfExists('subject_types');
    }
}
