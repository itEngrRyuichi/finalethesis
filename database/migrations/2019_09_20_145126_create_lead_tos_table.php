<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadTosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_tos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('access_id');
            $table->unsignedBigInteger('lead_id');
            $table->timestamps();

            //Foreign Keys
            $table->foreign('access_id')
                ->references('id')->on('accesscodes')
                ->onDelete('cascade');
            $table->foreign('lead_id')
                ->references('id')->on('user_types')
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
        Schema::dropIfExists('lead_tos');
    }
}
