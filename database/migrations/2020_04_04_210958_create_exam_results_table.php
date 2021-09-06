<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('exam_id');
            $table->tinyInteger('score')->default(0);
            $table->tinyInteger('is_remedial')->default(1);
            $table->tinyInteger('correction_status')->default(0);
            $table->tinyInteger('total_answered_question')->default(0);
            $table->tinyInteger('total_correct_answer')->default(0);
            $table->tinyInteger('total_wrong_answer')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('exam_results');
    }
}
