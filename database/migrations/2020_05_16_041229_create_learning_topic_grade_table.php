<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningTopicGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_topic_grade', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('grade_id');
            $table->unsignedInteger('learning_topic_id');
            $table->timestamps();

            $table->foreign('grade_id')->references('id')->on('grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('learning_topic_id')->references('id')->on('learning_topics')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_topic_grade');
    }
}
