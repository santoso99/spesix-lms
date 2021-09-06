<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLearningTopicForeignKeyExamQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_question', function (Blueprint $table) {
            $table->unsignedInteger('basic_competency_id')->nullable()->after('number');
            $table->foreign('basic_competency_id')->references('id')->on('basic_competencies')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_question', function (Blueprint $table) {
            $table->dropForeign(['basic_competency_id']);
            $table->dropColumn('basic_competency_id');
        });
    }
}
