<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicCompetencyTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_competency_topic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('basic_competency_id');
            $table->unsignedInteger('learning_topic_id');
            $table->timestamps();

            $table->foreign('basic_competency_id')->references('id')->on('basic_competencies')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('basic_competency_topic');
    }
}
