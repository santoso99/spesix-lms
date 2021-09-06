<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_competencies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('subject_id');
            $table->tinyInteger('grade_level');
            $table->text('competency');
            $table->timestamps();

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
        Schema::dropIfExists('basic_competencies');
    }
}
