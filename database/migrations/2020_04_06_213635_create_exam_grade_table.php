<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_grade', function (Blueprint $table) {
            $table->unsignedInteger('exam_id');
            $table->unsignedTinyInteger('grade_id');
            $table->timestamps();

            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_grade');
    }
}
