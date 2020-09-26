<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyDailyAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_daily_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('myAttendance_id');
            $table->unsignedBigInteger('attendanceStatus_id');
            $table->date('myAttendanceDate');
            $table->timestamps();

            //Foreign Keys
            $table->foreign('myAttendance_id')
                ->references('id')->on('my_attendances')
                ->onDelete('cascade');
            $table->foreign('attendanceStatus_id')
                ->references('id')->on('attendance_statuses')
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
        Schema::dropIfExists('my_daily_attendances');
    }
}
