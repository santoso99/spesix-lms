<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('file_path',255)->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('learning_topic_id')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('learning_materials');
    }
}
