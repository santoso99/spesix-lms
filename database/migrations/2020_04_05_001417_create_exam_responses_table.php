<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('answer')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('answer_choice_id')->nullable();
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('exam_result_id');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('score')->default(0);
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('answer_choice_id')->references('id')->on('answer_choices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('exam_result_id')->references('id')->on('exam_results')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_responses');
    }
}
