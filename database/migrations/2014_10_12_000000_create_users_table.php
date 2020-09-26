<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('userType_id');
            $table->string('school_id', 10);
            $table->string('name', 100);
            $table->date('birthday');
            $table->mediumText('address');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at');
            $table->mediumInteger('tel');
            $table->string('usable', 10);
            $table->binary('profilePic_location');
            $table->string('password', 20);
            $table->rememberToken();
            $table->timestamps();

            //Foreign Keys
            $table->foreign('section_id')
                ->references('id')->on('sections')
                ->onDelete('cascade');
            $table->foreign('child_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('userType_id')
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
        Schema::dropIfExists('users');
    }
}
