<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('start')->default(Carbon::create('now')->timestamp);
            $table->integer('end')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();            
            $table->unsignedBigInteger('task_id');
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_times');
    }
}
