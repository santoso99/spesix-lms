<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->text('instruction');
            $table->datetime('deadline');
            $table->tinyInteger('status');
            $table->text('attachment_path')->nullable();
            $table->string('attachment_filename')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('learning_topic_id');
            $table->unsignedTinyInteger('subject_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('learning_topic_id')->references('id')->on('learning_topics')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tasks');
    }
}
