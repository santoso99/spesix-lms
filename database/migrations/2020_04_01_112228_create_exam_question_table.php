<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_question', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('exam_id');
            $table->tinyInteger('number');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_question');
    }
}
