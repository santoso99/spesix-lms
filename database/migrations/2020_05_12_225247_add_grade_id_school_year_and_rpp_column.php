<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGradeIdSchoolYearAndRppColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_topics', function (Blueprint $table) {
            $table->unsignedTinyInteger('grade_id')->default(1)->after('grade_level');
            $table->string('school_year')->default('2019/2020')->after('grade_id');
            $table->text('rpp_file')->nullable()->after('basic_competency');

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
        Schema::table('learning_topics', function (Blueprint $table) {
            $table->dropForeign(['grade_id']);
            $table->dropColumn(['grade_id','school_year','rpp']);
        });
    }
}
