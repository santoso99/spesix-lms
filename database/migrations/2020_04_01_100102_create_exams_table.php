<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('subject_id');
            $table->string('enroll_code');
            $table->string('title',255);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('publish_status')->default(0);
            $table->date('date');
            $table->timeTz('time_start',0);
            $table->timeTz('time_end',0);
            $table->tinyInteger('total_question')->default(0);
            $table->tinyInteger('kkm_score');
            $table->tinyInteger('max_score');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
